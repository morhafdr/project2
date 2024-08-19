<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = Auth::user();

        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'national_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ];

        // Conditional password validation
        if ($this->filled('current_password') || $this->filled('new_password')) {
            $rules['current_password'] = [
                'required',
                'min:8',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('كلمة المرور الحالية غير صحيحة.');
                    }
                }
            ];
            $rules['new_password'] = 'nullable|string|min:8|confirmed';
        }

        return $rules;
    }


    /**
     * Get the validation messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'current_password.required' => 'يجب إدخال كلمة المرور الحالية عند تحديث كلمة المرور الجديدة.',
            'new_password.required' => 'يجب إدخال كلمة المرور الجديدة عند تحديثها.',
            'new_password.min' => 'يجب أن تتكون كلمة المرور الجديدة من الأقل 8 أحرف.',
            'new_password.confirmed' => 'تأكيد كلمة المرور الجديدة غير متطابق.',
            'national_number.unique' => 'هذا الرقم الوطني مستخدم بالفعل.',
            'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل.',
        ];
    }

}
