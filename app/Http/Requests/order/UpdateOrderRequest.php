<?php

namespace App\Http\Requests\order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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

            // Common fields that might be updated
            'customer_id' => 'nullable|exists:customers,id',
            'from_office_id' => 'nullable|exists:offices,id',
            'to_office_id' => 'nullable|exists:offices,id',
            'payment_method' => 'nullable|string|max:255',
            'payment_type' => 'nullable|string|max:255',

            // Optional fields that might change
            'S_user' => 'nullable|string|max:255',
            'S_national_id' => 'nullable|string|max:255',
            'S_phone_number' => 'nullable|string|max:255',
            'S_family_registration' => 'nullable|string|max:255',
            'S_mother_name' => 'nullable|string|max:255',
            'S_Location' => 'nullable|string|max:255',

            // Recipient details
            'R_user' => 'nullable|string|max:255',
            'R_phone_number' => 'nullable|string|max:255',

            // Goods details
            'incoming_goods' => 'nullable|array',
            'incoming_goods.*.good_name' => 'nullable|string|max:255',
            'incoming_goods.*.quantity' => 'nullable|integer',
            'incoming_goods.*.weight' => 'nullable|numeric',
            'incoming_goods.*.volume' => 'nullable|numeric',
        ];
    }
}
