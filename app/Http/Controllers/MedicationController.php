<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use App\Models\MedicineTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MedicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:medications-view')->only('index');
        $this->middleware('permission:medications-create')->only(['create', 'store']);
        $this->middleware('permission:medications-edit')->only(['edit', 'update']);
        $this->middleware('permission:medications-delete')->only('destroy');
    }

    /**
     * عرض الصفحة + البحث + وضع التعديل
     */
    public function index(Request $request)
    {
        $query = Medication::query();

        // 🔎 البحث
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('type', 'like', '%'.$request->search.'%');
        }

        $medications = $query->latest()->paginate(10);

        // ✏️ وضع التعديل
        $medication = null;
        if ($request->filled('edit')) {
            $medication = Medication::findOrFail($request->edit);
        }

        return view('hospital.medication.index', compact('medications', 'medication'));
    }

    /**
     * تخزين دواء جديد
     */
    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $data['qr_code'] = Str::uuid();

        Medication::create($data);

        return redirect()
            ->route('medications.index')
            ->with('success', 'تم إضافة الدواء بنجاح');
    }

    /**
     * تحديث دواء
     */
    public function update(Request $request, Medication $medication)
    {
        $data = $this->validateData($request);

        $medication->update($data);

        return redirect()
            ->route('medications.index')
            ->with('success', 'تم تحديث الدواء بنجاح');
    }

    /**
     * حذف دواء
     */
    public function destroy(Medication $medication)
    {
        $medication->delete();

        return redirect()
            ->route('medications.index')
            ->with('success', 'تم حذف الدواء بنجاح');
    }

    /**
     * قواعد التحقق
     */
    private function validateData(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);
    }

    public function scan($qr)
    {
        $medicine = Medication::where('qr_code', $qr)->firstOrFail();

        return view('hospital.medication.scan', compact('medicine'));
    }

    public function transaction(Request $request)
    {
        $medicine = Medication::findOrFail($request->medicine_id);

        if ($request->type == 'in') {
            $medicine->increment('quantity', $request->quantity);
        } else {
            if ($medicine->quantity < $request->quantity) {
                return response()->json(['error' => 'Not enough stock'], 422);
            }
            $medicine->decrement('quantity', $request->quantity);
        }

        MedicineTransaction::create([
            'medication_id' => $medicine->id,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'user_id' => auth()->id(),
        ]);

        return response()->json(['success' => true]);
    }
}
