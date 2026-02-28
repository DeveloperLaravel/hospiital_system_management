<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use App\Models\StockAlerts;
use Illuminate\Http\Request;

class StockAlertController extends Controller
{
    public function index(Request $request)
    {

        $medications = Medication::all();

        $alerts = StockAlerts::with('medication')

            ->when($request->search, function ($q) use ($request) {

                $q->whereHas('medication', function ($qq) use ($request) {

                    $qq->where(
                        'name',
                        'like',
                        "%$request->search%"
                    );

                });

            })

            ->when($request->status, function ($q) use ($request) {

                $q->where(
                    'status',
                    $request->status
                );

            })

            ->latest()

            ->paginate(10);

        return view(
            'stock_alerts.index',
            compact(
                'alerts',
                'medications'
            )
        );

    }

    public function store(Request $request)
    {

        $request->validate([

            'medication_id' => 'required',

            'current_stock' => 'required',

            'min_stock' => 'required',

            'status' => 'required',

        ]);

        StockAlerts::create([

            'medication_id' => $request->medication_id,

            'current_stock' => $request->current_stock,

            'min_stock' => $request->min_stock,

            'status' => $request->status,

            'alert_date' => now(),

            'notes' => $request->notes,

        ]);

        return back()->with(
            'success',
            'Alert created'
        );

    }

    public function update(
        Request $request,
        StockAlerts $stockAlert
    ) {

        $stockAlert->update(

            $request->only(

                'current_stock',
                'min_stock',
                'status',
                'notes'

            )

        );

        return back()->with(
            'success',
            'Alert updated'
        );

    }

    public function destroy(
        StockAlerts $stockAlert
    ) {

        $stockAlert->delete();

        return back()->with(
            'success',
            'Alert deleted'
        );

    }
}
