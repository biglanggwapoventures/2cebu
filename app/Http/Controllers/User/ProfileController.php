<?php

namespace App\Http\Controllers\User;

use App\Attraction;
use App\Http\Controllers\Controller;
use App\Rating;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Session;

class ProfileController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        $favorites = Attraction::forShowcase()->likedBy($user->id)->paginate(5, ['*'], 'likes-page');
        $reviews = Rating::with('attraction')->givenBy($user->id)->paginate(5, ['*'], 'reviews-page');

        return view('user.profile', [
            'favorites' => $favorites,
            'reviews' => $reviews,
        ]);
    }

    public function update(Request $request)
    {
        $input = $request->validate([
            'firstname' => ['required'],
            'lastname' => ['required'],
            'contact_number' => ['required', 'digits:11'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'password' => 'nullable|min:6',
            'password_confirmation' => 'required_with:password|same:password',
            'email' => ['required', 'email', Rule::unique('users')->ignore(Auth::id())],
        ], [
            'firstname.required' => 'Required.',
            'lastname.required' => 'Required.',
            'contact_number.required' => 'Required.',
            'contact_number.digits' => 'Should have an exact length of 11 digits',
            'gender.required' => 'Required.',
            'password.required' => 'Required.',
            'password_confirmation.required' => 'Required.',
            'email.required' => 'Required.',
        ]);

        if (!$input['password']) {
            unset($input['password']);
        }

        Auth::user()->update($input);

        Session::flash('growl', 'Your profile has been successfully updated!');

        return response()->json([
            'result' => true,
        ]);
    }
}
