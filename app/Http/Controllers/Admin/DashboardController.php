<?php

namespace App\Http\Controllers\Admin;

use App\Attraction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $attractionPendingReviews = Attraction::select('id', 'name', 'is_featured')->withPendingReviewsCount()->get();

        return view('admin.dashboard', [
            'attractionPendingReviews' => $attractionPendingReviews,
        ]);
    }
}
