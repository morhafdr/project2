<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDriverRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'national_id' => 'required|string|max:255',
            'driver_License_number' => 'required|unique:drivers,driver_License_number|string|max:255',
            'phone' => 'required|string|max:15',
            'join_date' => 'required|date',
            'status' => 'nullable|string|max:255'
        ];
    }
}
