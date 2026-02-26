<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('patient');

        // 🔎 بحث باسم المريض
        if ($request->search) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%');
            });
        }

        // 🔎 فلترة حسب الحالة
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $invoices = $query->latest()
            ->paginate(10);

        return view('hospital.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $patients = Patient::orderBy('name')->get();

        return view('hospital.invoices.form', compact('patients'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        Invoice::create($data);

        return redirect()
            ->route('invoices.index')
            ->with('success', 'تم إنشاء الفاتورة بنجاح');
    }

    public function edit(Invoice $invoice)
    {
        $patients = Patient::orderBy('name')->get();

        return view('hospital.invoices.form', compact('invoice', 'patients'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $data = $this->validateData($request);

        $invoice->update($data);

        return redirect()
            ->route('invoices.index')
            ->with('success', 'تم تعديل الفاتورة بنجاح');
    }

    public function destroy(Invoice $invoice)
    {
        // 🔐 لا نحذف الفاتورة المدفوعة
        if ($invoice->status === 'paid') {
            return back()->with('error', 'لا يمكن حذف فاتورة مدفوعة');
        }

        $invoice->delete();

        return back()->with('success', 'تم حذف الفاتورة');
    }

    private function validateData(Request $request)
    {
        return $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'total' => ['required', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['paid', 'unpaid'])],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | تعليم الفاتورة كمدفوعة
    |--------------------------------------------------------------------------
    */
    public function markPaid(Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return redirect()
                ->back()
                ->with('info', 'الفاتورة مدفوعة مسبقاً');
        }

        $invoice->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'تم تعليم الفاتورة كمدفوعة بنجاح');
    }

    /*
    |--------------------------------------------------------------------------
    | صفحة طباعة الفاتورة
    |--------------------------------------------------------------------------
    */
    public function print(Invoice $invoice)
    {
        // تحميل العلاقات المطلوبة
        $invoice->load([
            'patient',
            'items',
        ]);

        // إعادة حساب المجموع (حماية إضافية)
        $total = $invoice->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        // تحديث إذا اختلف
        if ($invoice->total != $total) {
            $invoice->update([
                'total' => $total,
            ]);
        }

        return view('hospital.invoices.print', compact('invoice'));
    }

    public function pay(Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return back()->with('info', 'الفاتورة مدفوعة مسبقًا');
        }

        $invoice->update(['status' => 'paid']);

        return back()->with('success', 'تم دفع الفاتورة بنجاح');
    }
}
