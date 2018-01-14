<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Rating;
use Auth;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function submitReview($attractionId, Request $request)
    {
        $input = $request->validate([
            'rating' => 'required|int|min:1|max:5',
            'review' => 'sometimes',
        ]);

        $input['attraction_id'] = $attractionId;
        $input['user_id'] = Auth::id();

        Rating::create($input);

        return response()->json([
            'result' => true,
        ]);
    }

    public function setStatus($id, Request $request)
    {
        $request->validate([
            'review_status' => 'required|in:rejected,approved',
        ]);

        Rating::whereId($id)->update([
            'rating_status' => $request->review_status,
        ]);

        return response()->json([
            'result' => true,
        ]);
    }
}
