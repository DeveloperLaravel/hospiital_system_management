<x-app-layout>
<div class="p-6 max-w-xl mx-auto bg-white shadow rounded">

<form method="POST"
      action="{{ isset($prescription)
          ? route('prescriptions.update', $prescription)
          : route('prescriptions.store') }}">

    @csrf
    @if(isset($prescription))
        @method('PUT')
    @endif

    <div class="mb-4">
        <label>السجل الطبي</label>
        <select name="medical_record_id" class="w-full border rounded p-2">
            @foreach($medicalRecords as $record)
                <option value="{{ $record->id }}"
                    @selected(old('medical_record_id',
                        $prescription->medical_record_id ?? '') == $record->id)>
                    {{ $record->patient->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label>الدواء</label>
        <select name="medication_id" class="w-full border rounded p-2">
            @foreach($medications as $med)
                <option value="{{ $med->id }}"
                    @selected(old('medication_id',
                        $prescription->medication_id ?? '') == $med->id)>
                    {{ $med->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label>الجرعة</label>
        <input type="text" name="dosage"
               value="{{ old('dosage', $prescription->dosage ?? '') }}"
               class="w-full border rounded p-2">
    </div>

    <div class="mb-4">
        <label>المدة</label>
        <input type="text" name="duration"
               value="{{ old('duration', $prescription->duration ?? '') }}"
               class="w-full border rounded p-2">
    </div>

    <button class="bg-green-600 text-white px-4 py-2 rounded">
        حفظ
    </button>

</form>

</div>
</x-app-layout>
