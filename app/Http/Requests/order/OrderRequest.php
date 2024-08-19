<?php

namespace App\Http\Requests\order;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
             //order
            'customer_id' => 'nullable|exists:customers,id',
            'from_office_id' => 'required|exists:offices,id',
            'to_office_id' => 'required|exists:offices,id',
            'payment_method' => 'required|string|max:255',
             'payment_type' => 'required|string|max:255',

            //order details
            'S_user' => 'required|string|max:255',
            'S_national_id' => 'required|string|max:255',
            'S_phone_number' => 'required|string|max:255',
            'S_family_registration' => 'required|string|max:255',
            'S_mother_name' => 'required|string|max:255',
            'S_Location' => 'nullable|string|max:255',

            // location
            'longitude' => 'nullable',
            'latitude' => 'nullable',
            //recive
            'R_user' => 'required|string|max:255',
            'R_phone_number' => 'required|string|max:255',
            // goods
            'incoming_goods' => 'required|array',
            'incoming_goods.*.good_name' => 'required|string|max:255',
            'incoming_goods.*.quantity' => 'required|integer',
            'incoming_goods.*.weight' => 'required',
        ];
    }
}
