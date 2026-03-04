<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicationRequest extends FormRequest
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
        $medicationId = $this->route('medication');

        return [
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'barcode' => 'nullable|string|unique:medications,barcode,'.$medicationId,
            'qr_code' => 'nullable|string|unique:medications,qr_code,'.$medicationId,
            'expiry_date' => 'nullable|date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'اسم الدواء مطلوب',
            'quantity.required' => 'الكمية مطلوبة',
            'price.required' => 'السعر مطلوب',
            'min_stock.required' => 'الحد الأدنى للمخزون مطلوب',
        ];
    }
}
