<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrescriptionItemRequest extends FormRequest
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
        return [
            'prescription_id' => 'required|exists:prescriptions,id',
            'medication_id' => 'required|exists:medications,id',
            'dosage' => 'required|string|max:255',
            'frequency' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'instructions' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'prescription_id.required' => 'الوصفة الطبية مطلوبة',
            'prescription_id.exists' => 'الوصفة الطبية غير موجودة',
            'medication_id.required' => 'الدواء مطلوب',
            'medication_id.exists' => 'الدواء غير موجود',
            'dosage.required' => 'الجرعة مطلوبة',
            'frequency.required' => 'التكرار مطلوب',
            'duration.required' => 'المدة مطلوبة',
            'duration.min' => 'المدة يجب أن تكون يوم واحد على الأقل',
            'quantity.required' => 'الكمية مطلوبة',
            'quantity.min' => 'الكمية يجب أن تكون 1 على الأقل',
        ];
    }

    /**
     * Get Arabic attribute names for validation errors.
     */
    public function attributes(): array
    {
        return [
            'prescription_id' => 'الوصفة الطبية',
            'medication_id' => 'الدواء',
            'dosage' => 'الجرعة',
            'frequency' => 'التكرار',
            'duration' => 'المدة',
            'quantity' => 'الكمية',
            'instructions' => 'التعليمات',
        ];
    }
}
