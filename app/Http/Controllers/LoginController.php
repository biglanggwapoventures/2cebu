<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Validator;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'exists:users'],
            'password' => 'required',
        ], [
            'username.exists' => 'This username does not link to any account.',
        ]);

        if ($validator->passes()) {
            if (Auth::attempt($request->all(['username', 'password']))) {
                return response()->json([
                    'result' => true,
                ]);
            } else {
                $validator->errors()->add('password', 'You entered an incorrect password');
            }
        }

        return response()->json([
            'result' => false,
            'errors' => $validator->errors(),
        ], 422);
    }
}
