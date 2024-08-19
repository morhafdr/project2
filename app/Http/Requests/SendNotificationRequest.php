<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendNotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Update the authorization to fit your security model
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|integer|exists:users,id', // Check if the user_id exists in the users table
            'title' => 'required|string|max:255', // Max length 255 characters
            'message' => 'required|string|max:1000', // Max length 1000 characters
        ];
    }
}
