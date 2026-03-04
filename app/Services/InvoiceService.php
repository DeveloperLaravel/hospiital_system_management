<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class InvoiceService
{
    /**
     * Get all invoices with relationships.
     */
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = Invoice::with(['patient', 'items']);

        // Apply search filter
        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->whereHas('patient', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                    ->orWhere('invoice_number', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by patient
        if (! empty($filters['patient_id'])) {
            $query->where('patient_id', $filters['patient_id']);
        }

        // Filter by date range
        if (! empty($filters['start_date']) && ! empty($filters['end_date'])) {
            $query->whereBetween('invoice_date', [$filters['start_date'], $filters['end_date']]);
        }

        return $query->latest()->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Get a single invoice by ID.
     */
    public function getById(int $id): ?Invoice
    {
        return Invoice::with(['patient', 'items'])->find($id);
    }

    /**
     * Create a new invoice.
     */
    public function create(array $data): Invoice
    {
        $invoice = Invoice::create([
            'invoice_number' => Invoice::generateNumber(),
            'patient_id' => $data['patient_id'],
            'invoice_date' => $data['invoice_date'] ?? now()->format('Y-m-d'),
            'due_date' => $data['due_date'] ?? null,
            'status' => $data['status'] ?? 'unpaid',
            'notes' => $data['notes'] ?? null,
            'total' => 0,
        ]);

        // Add items
        if (! empty($data['items'])) {
            foreach ($data['items'] as $itemData) {
                $this->addItem($invoice, $itemData);
            }
        }

        // Calculate total
        $this->calculateTotal($invoice);

        return $invoice->fresh(['patient', 'items']);
    }

    /**
     * Update an existing invoice.
     */
    public function update(Invoice $invoice, array $data): Invoice
    {
        $invoice->update([
            'patient_id' => $data['patient_id'],
            'invoice_date' => $data['invoice_date'] ?? $invoice->invoice_date,
            'due_date' => $data['due_date'] ?? $invoice->due_date,
            'status' => $data['status'] ?? $invoice->status,
            'notes' => $data['notes'] ?? $invoice->notes,
        ]);

        return $invoice->fresh(['patient', 'items']);
    }

    /**
     * Delete an invoice.
     */
    public function delete(Invoice $invoice): bool
    {
        // Delete all items first
        $invoice->items()->delete();

        return $invoice->delete();
    }

    /**
     * Add an item to an invoice.
     */
    public function addItem(Invoice $invoice, array $itemData): InvoiceItem
    {
        $item = $invoice->items()->create([
            'service' => $itemData['service'],
            'description' => $itemData['description'] ?? null,
            'price' => $itemData['price'],
            'quantity' => $itemData['quantity'],
        ]);

        // Recalculate total
        $this->calculateTotal($invoice);

        return $item;
    }

    /**
     * Update an invoice item.
     */
    public function updateItem(InvoiceItem $item, array $data): InvoiceItem
    {
        $item->update([
            'service' => $data['service'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'quantity' => $data['quantity'],
        ]);

        // Recalculate total
        $this->calculateTotal($item->invoice);

        return $item->fresh();
    }

    /**
     * Delete an invoice item.
     */
    public function deleteItem(InvoiceItem $item): bool
    {
        $invoice = $item->invoice;
        $result = $item->delete();

        // Recalculate total
        $this->calculateTotal($invoice);

        return $result;
    }

    /**
     * Calculate invoice total.
     */
    public function calculateTotal(Invoice $invoice): void
    {
        $total = $invoice->items()->sum(\Illuminate\Support\Facades\DB::raw('price * quantity'));
        $invoice->update(['total' => $total]);
    }

    /**
     * Mark invoice as paid.
     */
    public function markAsPaid(Invoice $invoice): Invoice
    {
        $invoice->update(['status' => 'paid']);
        $invoice->update(['paid_at' => now()]);

        return $invoice->fresh();
    }

    /**
     * Mark invoice as unpaid.
     */
    public function markAsUnpaid(Invoice $invoice): Invoice
    {
        $invoice->update(['status' => 'unpaid']);
        $invoice->update(['paid_at' => null]);

        return $invoice->fresh();
    }

    /**
     * Get invoice with full details.
     */
    public function getWithDetails(Invoice $invoice): Invoice
    {
        return $invoice->load(['patient', 'items']);
    }

    /**
     * Get available patients for dropdown.
     */
    public function getAvailablePatients(): Collection
    {
        return Patient::orderBy('name')->get();
    }

    /**
     * Get invoice statistics.
     */
    public function getStatistics(array $filters = []): array
    {
        $query = Invoice::query();

        if (! empty($filters['start_date']) && ! empty($filters['end_date'])) {
            $query->whereBetween('invoice_date', [$filters['start_date'], $filters['end_date']]);
        }

        $totalInvoices = (clone $query)->count();
        $totalAmount = (clone $query)->sum('total');
        $paidAmount = (clone $query)->where('status', 'paid')->sum('total');
        $unpaidAmount = (clone $query)->where('status', 'unpaid')->sum('total');

        return [
            'total_invoices' => $totalInvoices,
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'unpaid_amount' => $unpaidAmount,
        ];
    }

    /**
     * Get unpaid invoices.
     */
    public function getUnpaidInvoices(): Collection
    {
        return Invoice::where('status', 'unpaid')
            ->with('patient')
            ->orderBy('due_date')
            ->get();
    }

    /**
     * Get overdue invoices.
     */
    public function getOverdueInvoices(): Collection
    {
        return Invoice::where('status', 'unpaid')
            ->where('due_date', '<', now())
            ->with('patient')
            ->get();
    }
}
