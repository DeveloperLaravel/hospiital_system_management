<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $departmentId = $this->route('department')?->id;

        return [
            'name' => ['required', 'string', 'max:255', 'unique:departments,name,'.$departmentId],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'حقل اسم القسم مطلوب',
            'name.string' => 'يجب أن يكون اسم القسم نصاً',
            'name.max' => 'يجب ألا يتجاوز اسم القسم 255 حرفاً',
            'name.unique' => 'اسم القسم مسجل مسبقاً',
            'description.max' => 'يجب ألا يتجاوز الوصف 1000 حرف',
        ];
    }
}
