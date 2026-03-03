<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Services\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    protected $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;

        $this->middleware('permission:patients-view')->only(['index', 'show', 'search']);
        $this->middleware('permission:patients-create')->only(['store', 'create']);
        $this->middleware('permission:patients-edit')->only(['edit', 'update', 'addPayment', 'addCharge']);
        $this->middleware('permission:patients-delete')->only('destroy');
    }

    /**
     * عرض قائمة المرضى مع البحث والفلترة
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'gender', 'blood_type', 'balance_status']);

        if ($request->has('search') || $request->has('gender') || $request->has('blood_type') || $request->has('balance_status')) {
            $patients = $this->patientService->searchPatients($filters);
        } else {
            $patients = $this->patientService->getAllPatients();
        }

        $statistics = $this->patientService->getStatistics();

        return view('hospital.patients.index', compact('patients', 'statistics', 'filters'));
    }

    /**
     * عرض تفاصيل مريض واحد
     */
    public function show(Patient $patient)
    {
        $patient = $this->patientService->getPatientWithDetails($patient->id);

        if (! $patient) {
            return redirect()->back()->with('error', 'المريض غير موجود');
        }

        return view('hospital.patients.show', compact('patient'));
    }

    /**
     * البحث السريع (AJAX)
     */
    public function search(Request $request)
    {
        $request->validate([
            'term' => 'required|string|min:2',
        ]);

        $patients = $this->patientService->searchPatientsSimple($request->term);

        return response()->json($patients);
    }

    /**
     * إنشاء مريض جديد
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'national_id' => 'nullable|string|max:20|unique:patients,national_id',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|in:male,female',
            'phone' => 'nullable|string|max:20',
            'blood_type' => 'nullable|string|max:5',
            'address' => 'nullable|string',
            'balance' => 'nullable|numeric|min:0',
            'total_paid' => 'nullable|numeric|min:0',
            'credit_limit' => 'nullable|numeric|min:0',
        ]);

        $this->patientService->createPatient($validated);

        return redirect()->back()->with('success', 'تم إضافة المريض بنجاح');
    }

    /**
     * تحديث بيانات مريض
     */
    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'national_id' => 'nullable|string|max:20|unique:patients,national_id,'.$patient->id,
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|in:male,female',
            'phone' => 'nullable|string|max:20',
            'blood_type' => 'nullable|string|max:5',
            'address' => 'nullable|string',
            'balance' => 'nullable|numeric|min:0',
            'total_paid' => 'nullable|numeric|min:0',
            'credit_limit' => 'nullable|numeric|min:0',
        ]);

        $this->patientService->updatePatient($patient, $validated);

        return redirect()->back()->with('success', 'تم تعديل بيانات المريض بنجاح');
    }

    /**
     * حذف المريض
     */
    public function destroy(Patient $patient)
    {
        try {
            $this->patientService->deletePatient($patient);

            return redirect()->back()->with('success', 'تم حذف المريض بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'لا يمكن حذف المريض لوجود سجلات مرتبطة به');
        }
    }

    /**
     * إضافة دفعة للمريض
     */
    public function addPayment(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        try {
            $this->patientService->addPayment($patient, $validated['amount']);

            return redirect()->back()->with('success', 'تم إضافة الدفعة بنجاح');
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * إضافة رسوم للمريض
     */
    public function addCharge(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        try {
            $this->patientService->addCharge($patient, $validated['amount']);

            return redirect()->back()->with('success', 'تم إضافة الرسوم بنجاح');
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * تحديث الحد الائتماني
     */
    public function updateCreditLimit(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'credit_limit' => 'required|numeric|min:0',
        ]);

        $this->patientService->updateCreditLimit($patient, $validated['credit_limit']);

        return redirect()->back()->with('success', 'تم تحديث الحد الائتماني بنجاح');
    }
}
