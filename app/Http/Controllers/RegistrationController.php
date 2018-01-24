<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{
    public function __invoke(Request $request, User $user)
    {
        $input = $request->validate([
            'firstname' => ['required'],
            'lastname' => ['required'],
            'contact_number' => ['required', 'digits:11'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
            'email' => ['required', 'email'],
            'username' => ['required', Rule::unique($user->getTable())],
        ], [
            'firstname.required' => 'Required.',
            'lastname.required' => 'Required.',
            'contact_number.required' => 'Required.',
            'contact_number.digits' => 'Should have an exact length of 11 digits',
            'gender.required' => 'Required.',
            'password.required' => 'Required.',
            'password_confirmation.required' => 'Required.',
            'email.required' => 'Required.',
            'username.required' => 'Required.',
        ]);

        $user = User::create($input);

        Auth::login($user);

        return response()->json([
            'result' => true,
        ]);
    }
}
