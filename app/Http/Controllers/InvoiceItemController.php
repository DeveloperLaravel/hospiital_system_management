<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceItemRequest;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Services\InvoiceItemService;

class InvoiceItemController extends Controller
{
    protected $service;

    public function __construct(InvoiceItemService $service)
    {
        $this->service = $service;
    }

    /**
     * عرض كل الخدمات الخاصة بفاتورة معينة
     */
    public function index(Invoice $invoice)
    {
        $items = $invoice->items()->latest()->get();

        return view('hospital.invoice_items.index', compact('invoice', 'items'));
    }

    /**
     * نموذج إضافة خدمة
     */
    public function create(Invoice $invoice)
    {
        // منع الإضافة لو الفاتورة مدفوعة
        if ($invoice->status === 'paid') {
            return back()->with('error', 'لا يمكن تعديل فاتورة مدفوعة');
        }

        return view('hospital.invoice_items.create', compact('invoice'));
    }

    /**
     * حفظ الخدمة
     */
    public function store(InvoiceItemRequest $request, Invoice $invoice)
    {
        try {
            $this->service->create($invoice, $request->validated());

            return redirect()
                ->route('invoices.items.index', $invoice)
                ->with('success', 'تم إضافة الخدمة بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * نموذج تعديل
     */
    public function edit(Invoice $invoice, InvoiceItem $item)
    {
        if ($invoice->status === 'paid') {
            return back()->with('error', 'لا يمكن تعديل فاتورة مدفوعة');
        }

        return view('hospital.invoice_items.edit', compact('invoice', 'item'));
    }

    /**
     * تحديث الخدمة
     */
    public function update(InvoiceItemRequest $request, Invoice $invoice, InvoiceItem $item)
    {
        try {
            $this->service->update($item, $request->validated());

            return redirect()
                ->route('invoices.items.index', $invoice)
                ->with('success', 'تم تعديل الخدمة بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * حذف الخدمة
     */
    public function destroy(Invoice $invoice, InvoiceItem $item)
    {
        try {
            $this->service->delete($item);

            return back()->with('success', 'تم حذف الخدمة بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Get items as JSON for AJAX
     */
    public function getItems(Invoice $invoice)
    {
        $items = $this->service->getFormattedItems($invoice);

        return response()->json([
            'success' => true,
            'items' => $items,
            'total' => number_format($invoice->total, 2),
        ]);
    }

    /**
     * عرض عنصر محدد من الفاتورة
     */
    public function show(Invoice $invoice, InvoiceItem $item)
    {
        return view('hospital.invoice_items.show', compact('invoice', 'item'));
    }
}
