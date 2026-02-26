<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
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
        $roomId = $this->route('room')->id;

        return [
            'room_number' => 'required|string|max:50|unique:rooms,room_number,'.$roomId,
            'type' => 'required|in:single,double,ICU',
            'status' => 'required|in:available,occupied',
        ];
    }
}
