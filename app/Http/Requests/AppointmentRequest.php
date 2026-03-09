<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppointmentRequest extends FormRequest
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
        $appointmentId = $this->route('appointment')?->id;

        return [
            'patient_id' => [
                'required',
                'exists:patients,id',
                Rule::unique('appointments')->ignore($appointmentId)->where(function ($query) {
                    return $query->where('date', $this->date)
                        ->where('time', $this->time);
                }),
            ],
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'status' => [
                'required',
                Rule::in(['pending', 'confirmed', 'completed', 'cancelled', 'no_show']),
            ],
            'notes' => 'nullable|string|max:1000',
            'appointment_type' => 'nullable|in:checkup,followup,emergency,consultation',
            'is_emergency' => 'nullable|boolean',
            'duration' => 'nullable|integer|min:15|max:180',
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
            'patient_id.unique' => 'المريض لديه موعد في نفس التاريخ والوقت',
            'doctor_id.required' => 'يرجى اختيار الطبيب',
            'doctor_id.exists' => 'الطبيب المحدد غير موجود',
            'date.required' => 'يرجى إدخال التاريخ',
            'date.date' => 'التاريخ غير صالح',
            'date.after_or_equal' => 'يجب أن يكون التاريخ اليوم أو بعده',
            'time.required' => 'يرجى إدخال الوقت',
            'status.required' => 'يرجى اختيار الحالة',
            'status.in' => 'الحالة المختارة غير صالحة',
            'notes.max' => 'الملاحظات يجب ألا تتجاوز 1000 حرف',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // If no status is provided, set default to pending
        if (! $this->has('status')) {
            $this->merge(['status' => 'pending']);
        }
    }
}
