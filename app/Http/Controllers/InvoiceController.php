<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceItemRequest;
use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Services\InvoiceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected $service;

    public function __construct(InvoiceService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'status', 'patient_id', 'start_date', 'end_date']);

        $invoices = $this->service->getAll($filters);
        $patients = $this->service->getAvailablePatients();
        $statistics = $this->service->getStatistics($filters);

        return view('hospital.invoices.index', compact(
            'invoices', 'patients', 'statistics'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = $this->service->getAvailablePatients();

        return view('hospital.invoices.create', compact('patients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {
        $invoice = $this->service->create($request->validated());

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'تم إنشاء الفاتورة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice = $this->service->getWithDetails($invoice);

        return view('hospital.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $invoice = $this->service->getById($invoice->id);
        $patients = $this->service->getAvailablePatients();

        return view('hospital.invoices.edit', compact('invoice', 'patients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        $this->service->update($invoice, $request->validated());

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'تم تحديث الفاتورة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $this->service->delete($invoice);

        return redirect()->route('invoices.index')
            ->with('success', 'تم حذف الفاتورة بنجاح');
    }

    /**
     * Add item to invoice.
     */
    public function addItem(InvoiceItemRequest $request, Invoice $invoice)
    {
        $this->service->addItem($invoice, $request->validated());

        return back()->with('success', 'تم إضافة العنصر بنجاح');
    }

    /**
     * Update invoice item.
     */
    public function updateItem(InvoiceItemRequest $request, InvoiceItem $item)
    {
        $this->service->updateItem($item, $request->validated());

        return back()->with('success', 'تم تحديث العنصر بنجاح');
    }

    /**
     * Delete invoice item.
     */
    public function deleteItem(InvoiceItem $item)
    {
        $this->service->deleteItem($item);

        return back()->with('success', 'تم حذف العنصر بنجاح');
    }

    /**
     * Mark invoice as paid.
     */
    public function markAsPaid(Invoice $invoice)
    {
        $this->service->markAsPaid($invoice);

        return back()->with('success', 'تم تحديد الفاتورة كمدفوعة');
    }

    /**
     * Mark invoice as unpaid.
     */
    public function markAsUnpaid(Invoice $invoice)
    {
        $this->service->markAsUnpaid($invoice);

        return back()->with('success', 'تم تحديد الفاتورة كغير مدفوعة');
    }

    /**
     * Export invoice to PDF.
     */
    public function exportPdf(Invoice $invoice)
    {
        $invoice = $this->service->getWithDetails($invoice);

        $pdf = Pdf::loadView('hospital.invoices.pdf', compact('invoice'));

        return $pdf->stream('invoice-'.$invoice->invoice_number.'.pdf');
    }

    /**
     * Get unpaid invoices (API).
     */
    public function getUnpaid()
    {
        $invoices = $this->service->getUnpaidInvoices();

        return response()->json([
            'success' => true,
            'invoices' => $invoices,
        ]);
    }

    /**
     * Get overdue invoices (API).
     */
    public function getOverdue()
    {
        $invoices = $this->service->getOverdueInvoices();

        return response()->json([
            'success' => true,
            'invoices' => $invoices,
        ]);
    }

    /**
     * Get invoice statistics (API).
     */
    public function getStatistics(Request $request)
    {
        $filters = $request->only(['start_date', 'end_date']);
        $statistics = $this->service->getStatistics($filters);

        return response()->json([
            'success' => true,
            'statistics' => $statistics,
        ]);
    }
}
