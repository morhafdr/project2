<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }


    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        try {
            $user = Auth::user();

            // Update profile fields (first_name, last_name, father_name, etc.)
            $user->fill($request->only(['first_name', 'last_name', 'father_name', 'mother_name', 'national_number', 'phone', 'email']));
            $user->save();

            // Update password if new password is provided
            if ($request->filled('new_password')) {
                $user->password = Hash::make($request->new_password);
                $user->save();
            }

            // Flash success message
            session()->flash('success', 'تم تحديث الملف الشخصي بنجاح.');

            return redirect()->route('profile.edit');
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء تحديث الملف الشخصي: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }



}
