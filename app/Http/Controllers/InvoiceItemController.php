<?php

// app/Http/Controllers/InvoiceItemController.php

// app/Http/Controllers/InvoiceItemController.php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;

class InvoiceItemController extends Controller
{
    /**
     * عرض كل الخدمات الخاصة بفاتورة معينة
     */
    public function index(Invoice $invoice)
    {
        $invoice->load('items');

        return view('hospital.invoice_items.index', compact('invoice'));
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

        return view('hospital.invoice_items.form', compact('invoice'));
    }

    /**
     * حفظ الخدمة
     */
    public function store(Request $request, Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return back()->with('error', 'لا يمكن تعديل فاتورة مدفوعة');
        }

        $data = $request->validate([
            'service' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $invoice->items()->create($data);

        $invoice->updateTotal(); // 🔥 تحديث المجموع

        return redirect()
            ->route('invoices.items.index', $invoice)
            ->with('success', 'تم إضافة الخدمة بنجاح');
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
    public function update(Request $request, Invoice $invoice, InvoiceItem $item)
    {
        if ($invoice->status === 'paid') {
            return back()->with('error', 'لا يمكن تعديل فاتورة مدفوعة');
        }

        $data = $request->validate([
            'service' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $item->update($data);

        $invoice->updateTotal(); // 🔥 تحديث المجموع

        return redirect()
            ->route('invoices.items.index', $invoice)
            ->with('success', 'تم تعديل الخدمة بنجاح');
    }

    /**
     * حذف الخدمة
     */
    public function destroy(Invoice $invoice, InvoiceItem $item)
    {
        if ($invoice->status === 'paid') {
            return back()->with('error', 'لا يمكن تعديل فاتورة مدفوعة');
        }

        $item->delete();

        $invoice->updateTotal(); // 🔥 تحديث المجموع

        return back()->with('success', 'تم حذف الخدمة');
    }
}
