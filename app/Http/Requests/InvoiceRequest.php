<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'patient_id' => 'required|exists:patients,id',
            'invoice_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:invoice_date',
            'status' => 'nullable|in:draft,unpaid,paid,cancelled',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.service' => 'required|string|max:255',
            'items.*.description' => 'nullable|string|max:500',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'patient_id.required' => 'المريض مطلوب',
            'patient_id.exists' => 'المريض غير موجود',
            'items.required' => 'يجب إضافة عنصر واحد على الأقل',
            'items.*.service.required' => 'اسم الخدمة مطلوب',
            'items.*.price.required' => 'السعر مطلوب',
            'items.*.price.min' => 'السعر يجب أن يكون رقماً موجباً',
            'items.*.quantity.required' => 'الكمية مطلوبة',
            'items.*.quantity.min' => 'الكمية يجب أن تكون 1 على الأقل',
            'due_date.after_or_equal' => 'تاريخ الاستحقاق يجب أن يكون بعد تاريخ الفاتورة أو نفس التاريخ',
        ];
    }

    /**
     * Get Arabic attribute names for validation errors.
     */
    public function attributes(): array
    {
        return [
            'patient_id' => 'المريض',
            'invoice_date' => 'تاريخ الفاتورة',
            'due_date' => 'تاريخ الاستحقاق',
            'notes' => 'ملاحظات',
            'items' => 'ال عناصر',
            'items.*.service' => 'الخدمة',
            'items.*.description' => 'الوصف',
            'items.*.price' => 'السعر',
            'items.*.quantity' => 'الكمية',
        ];
    }
}
