<?php

namespace App\Http\Controllers\User;

use App\Attraction;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        $favorites = Attraction::forShowcase()->likedBy($user->id)->paginate(3);

        return view('user.profile', [
            'favorites' => $favorites,
        ]);
    }
}
