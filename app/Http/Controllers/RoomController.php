<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Patient;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where('room_number', 'like', '%'.$request->search.'%');
        }

        $rooms = $query->latest()->paginate(10);

        $patients = Patient::whereDoesntHave('rooms', function ($q) {
            $q->whereNull('discharged_at');
        })->get();

        return view('hospital.rooms.index', compact('rooms', 'patients'));
    }

    public function create()
    {
        return view('hospital.rooms.create');
    }

    public function store(StoreRoomRequest $request)
    {
        Room::create($request->validated());

        return redirect()->route('rooms.index')->with('success', 'تم إضافة الغرفة بنجاح ✅');
    }

    public function edit(Room $room)
    {
        return view('hospital.rooms.edit', compact('room'));
    }

    public function update(UpdateRoomRequest $request, Room $room)
    {
        $room->update($request->validated());

        return redirect()->route('rooms.index')->with('success', 'تم تحديث الغرفة بنجاح 🔄');
    }

    public function destroy(Room $room)
    {
        if ($room->status === 'occupied') {
            return back()->with('error', 'لا يمكن حذف غرفة مشغولة ⚠️');
        }

        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'تم حذف الغرفة بنجاح 🗑️');
    }

    public function admit(Request $request, Room $room)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
        ]);

        if ($room->status === 'occupied') {
            return back()->with('error', 'الغرفة مشغولة ⚠️');
        }

        $room->patients()->attach($request->patient_id, [
            'admitted_at' => now(),
        ]);

        $room->update(['status' => 'occupied']);

        return back()->with('success', 'تم إدخال المريض بنجاح 🏥');
    }

    public function discharge(Room $room)
    {
        $currentPatient = $room->patients()->wherePivotNull('discharged_at')->first();

        if (! $currentPatient) {
            return back()->with('error', 'لا يوجد مريض حاليًا ⚠️');
        }

        $room->patients()->updateExistingPivot($currentPatient->id, [
            'discharged_at' => now(),
        ]);

        $room->update(['status' => 'available']);

        return back()->with('success', 'تم إخراج المريض ✅');
    }
}
