<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class LikeAttractionController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'attraction_id' => ['required', Rule::exists('attractions', 'id')->where(function ($q) {
                return $q->whereAttractionStatus('approved');
            })],
        ]);

        $result = Auth::user()->likedAttractions()->toggle($request->attraction_id);

        return response()->json([
            'result' => true,
            'change' => empty($result['attached']) ? '-' : '+',
        ]);

    }
}
