<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Collection;

class InvoiceItemService
{
    /**
     * Get all items for a specific invoice.
     */
    public function getByInvoice(Invoice $invoice): Collection
    {
        return $invoice->items()->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get a single item by ID.
     */
    public function getById(int $id): ?InvoiceItem
    {
        return InvoiceItem::find($id);
    }

    /**
     * Create a new invoice item.
     */
    public function create(Invoice $invoice, array $data): InvoiceItem
    {
        // Prevent editing if invoice is paid
        if ($invoice->status === 'paid') {
            throw new \Exception('لا يمكن تعديل فاتورة مدفوعة');
        }

        $item = $invoice->items()->create([
            'service' => $data['service'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'quantity' => $data['quantity'] ?? 1,
        ]);

        // Recalculate invoice total
        $this->calculateInvoiceTotal($invoice);

        return $item;
    }

    /**
     * Update an existing invoice item.
     */
    public function update(InvoiceItem $item, array $data): InvoiceItem
    {
        $invoice = $item->invoice;

        // Prevent editing if invoice is paid
        if ($invoice->status === 'paid') {
            throw new \Exception('لا يمكن تعديل فاتورة مدفوعة');
        }

        $item->update([
            'service' => $data['service'],
            'description' => $data['description'] ?? $item->description,
            'price' => $data['price'],
            'quantity' => $data['quantity'] ?? $item->quantity,
        ]);

        // Recalculate invoice total
        $this->calculateInvoiceTotal($invoice);

        return $item->fresh();
    }

    /**
     * Delete an invoice item.
     */
    public function delete(InvoiceItem $item): bool
    {
        $invoice = $item->invoice;

        // Prevent editing if invoice is paid
        if ($invoice->status === 'paid') {
            throw new \Exception('لا يمكن تعديل فاتورة مدفوعة');
        }

        $result = $item->delete();

        // Recalculate invoice total
        $this->calculateInvoiceTotal($invoice);

        return $result;
    }

    /**
     * Calculate and update invoice total.
     */
    public function calculateInvoiceTotal(Invoice $invoice): void
    {
        $total = $invoice->items()->selectRaw('SUM(price * quantity) as total')->value('total') ?? 0;
        $invoice->update(['total' => $total]);
    }

    /**
     * Get items formatted for display.
     */
    public function getFormattedItems(Invoice $invoice): array
    {
        return $invoice->items()->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'service' => $item->service,
                'description' => $item->description,
                'price' => number_format($item->price, 2),
                'quantity' => $item->quantity,
                'total' => number_format($item->price * $item->quantity, 2),
                'created_at' => $item->created_at->format('Y-m-d H:i'),
            ];
        })->toArray();
    }

    /**
     * Bulk create items for an invoice.
     */
    public function bulkCreate(Invoice $invoice, array $items): Collection
    {
        // Prevent editing if invoice is paid
        if ($invoice->status === 'paid') {
            throw new \Exception('لا يمكن تعديل فاتورة مدفوعة');
        }

        $createdItems = [];
        foreach ($items as $itemData) {
            $createdItems[] = $invoice->items()->create([
                'service' => $itemData['service'],
                'description' => $itemData['description'] ?? null,
                'price' => $itemData['price'],
                'quantity' => $itemData['quantity'] ?? 1,
            ]);
        }

        // Recalculate invoice total
        $this->calculateInvoiceTotal($invoice);

        return collect($createdItems);
    }
}
