<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceItemRequest extends FormRequest
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
            'service' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'service.required' => 'اسم الخدمة مطلوب',
            'service.max' => 'اسم الخدمة طويل جداً',
            'price.required' => 'السعر مطلوب',
            'price.min' => 'السعر يجب أن يكون أكبر من صفر',
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
            'service' => 'اسم الخدمة',
            'description' => 'الوصف',
            'price' => 'السعر',
            'quantity' => 'الكمية',
        ];
    }
}
