<?php

namespace App\Http\Controllers;

use App\Attraction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('welcome', [
            'data' => Attraction::approved()->with(['photos', 'categories', 'tags'])->get(),
        ]);
    }
}
