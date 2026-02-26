<x-app-layout>
<div class="p-6 max-w-lg mx-auto bg-white shadow rounded">

<form method="POST"
      action="{{ isset($invoice)
            ? route('invoices.update',$invoice)
            : route('invoices.store') }}">

    @csrf
    @if(isset($invoice))
        @method('PUT')
    @endif

    <div class="mb-4">
        <label>المريض</label>
        <select name="patient_id" class="w-full border rounded p-2">
            @foreach($patients as $patient)
                <option value="{{ $patient->id }}"
                    @selected(old('patient_id',
                        $invoice->patient_id ?? '') == $patient->id)>
                    {{ $patient->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label>المبلغ</label>
        <input type="number"
               step="0.01"
               name="total"
               value="{{ old('total',$invoice->total ?? 0) }}"
               class="w-full border rounded p-2">
    </div>

    <div class="mb-4">
        <label>الحالة</label>
        <select name="status" class="w-full border rounded p-2">
            <option value="unpaid"
                @selected(old('status',$invoice->status ?? '')=='unpaid')>
                غير مدفوعة
            </option>
            <option value="paid"
                @selected(old('status',$invoice->status ?? '')=='paid')>
                مدفوعة
            </option>
        </select>
    </div>

    <button class="bg-green-600 text-white px-4 py-2 rounded">
        حفظ
    </button>

</form>

</div>
</x-app-layout>
