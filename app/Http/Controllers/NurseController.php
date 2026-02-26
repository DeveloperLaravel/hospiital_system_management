<?php

namespace App\Http\Controllers;

use App\Http\Requests\NurseRequest;
use App\Models\Department;
use App\Models\Nurse;
use App\Services\NurseService;
use Illuminate\Http\Request;

class NurseController extends Controller
{
    // 1️⃣ inject NurseService
    public function __construct(private NurseService $service)
    {
        // 2️⃣ middleware الصلاحيات
        $this->middleware('permission:nurses.view')->only('index');
        $this->middleware('permission:nurses.create')->only('store');
        $this->middleware('permission:nurses.edit')->only('update');
        $this->middleware('permission:nurses.delete')->only('destroy');
    }

    public function index(Request $request)
    {
        $nurses = $this->service->paginate(
            $request->only([
                'search',
                'department_id',
            ])
        );

        $departments = Department::all();

        return view(
            'hospital.nurses.index',
            compact('nurses', 'departments')
        );
    }

    public function store(NurseRequest $request)
    {
        $this->service->store(
            $request->validated()
        );

        return redirect()
            ->route('nurses.index')
            ->with('success', 'تم الإضافة بنجاح');
    }

    public function update(
        NurseRequest $request,
        Nurse $nurse
    ) {
        $this->service->update(
            $nurse,
            $request->validated()
        );

        return back()
            ->with('success', 'تم التحديث');
    }

    public function destroy(Nurse $nurse)
    {
        $this->service->delete($nurse);

        return back()
            ->with('success', 'تم الحذف');
    }
}
