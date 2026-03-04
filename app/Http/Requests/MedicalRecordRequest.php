<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicalRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $medicalRecordId = $this->route('medical_record')?->id;

        return [
            'patient_id' => [
                'required',
                'exists:patients,id',
            ],
            'doctor_id' => [
                'required',
                'exists:doctors,id',
            ],
            'appointment_id' => [
                'nullable',
                'exists:appointments,id',
            ],
            'visit_date' => [
                'required',
                'date',
            ],
            'diagnosis' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'treatment' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'patient_id.required' => 'يرجى اختيار المريض',
            'patient_id.exists' => 'المريض المحدد غير موجود',
            'doctor_id.required' => 'يرجى اختيار الطبيب',
            'doctor_id.exists' => 'الطبيب المحدد غير موجود',
            'appointment_id.exists' => 'الموعد المحدد غير موجود',
            'visit_date.required' => 'يرجى إدخال تاريخ الزيارة',
            'visit_date.date' => 'التاريخ غير صالح',
            'diagnosis.max' => 'التشخيص يجب ألا يتجاوز 5000 حرف',
            'treatment.max' => 'العلاج يجب ألا يتجاوز 5000 حرف',
            'notes.max' => 'الملاحظات يجب ألا تتجاوز 2000 حرف',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // If no visit date is provided, set it to today
        if (! $this->has('visit_date')) {
            $this->merge(['visit_date' => now()->toDateString()]);
        }
    }
}
