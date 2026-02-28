<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Patient;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {

        $invoices = Invoice::with('patient')
            ->latest()
            ->paginate(10);

        return view('hospital.invoices.index', compact(
            'invoices'
        ));
    }

    public function create()
    {
        $patients = Patient::all();

        return view('invoices.create',
            compact('patients'));
    }

    public function store(Request $request)
    {

        $request->validate([

            'patient_id' => 'required',

            'items.*.name' => 'required',

            'items.*.price' => 'required|numeric',

            'items.*.quantity' => 'required|numeric',

        ]);

        $invoice = Invoice::create([

            'invoice_number' => Invoice::generateNumber(),

            'patient_id' => $request->patient_id,

            'invoice_date' => now(),

            'status' => 'unpaid',

        ]);

        foreach ($request->items as $item) {

            $total =
            $item['price']
            *
            $item['quantity'];

            $invoice->items()->create([

                'name' => $item['name'],

                'price' => $item['price'],

                'quantity' => $item['quantity'],

                'total' => $total,

            ]);
        }

        $invoice->calculateTotal();

        return redirect()
            ->route('invoices.show', $invoice);
    }

    public function show(Invoice $invoice)
    {

        $invoice->load([
            'patient',
            'items',
        ]);

        return view(
            'hospital.invoices.show',
            compact('invoice')
        );
    }

    public function destroy(Invoice $invoice)
    {

        $invoice->delete();

        return back();
    }
}
