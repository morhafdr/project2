<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'email' => 'required|email|unique:users',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'national_number' => 'required|numeric|unique:users',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'password' => 'required|string|min:8|confirmed',
            'office_id' => 'required|exists:offices,id',
            'join_date' => 'required|date',
            'salary' => 'required|numeric',
            'role_id'=>'required'
        ];
    }
}
