<?php

namespace App\Http\Controllers;

use App\Attraction;
use App\AttractionCategory;
use App\Province;
use Illuminate\Http\Request;
use View;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $hasPerformedSearch = $this->hasPerformedSearch();
        $top = Attraction::forShowcase()->top(6);
        $newest = Attraction::forShowcase()->newest(6);

        $q = $hasPerformedSearch ? $this->performSearch() : null;
        $featured = $hasPerformedSearch ? collect([]) : Attraction::featured()->get();

        return View::make('welcome', [
            'q' => $q,
            'hasPerformedSearch' => $hasPerformedSearch,
            'featured' => $featured,
            'newest' => $newest->get(),
            'top' => $top->get()->sortByDesc('average_rating'),
            'provinces' => Province::dropdownFormat(),
            'categories' => AttractionCategory::dropdownFormat(),
        ]);
    }

    public function performSearch()
    {
        // DB::enableQueryLog();
        $request = request();
        $attraction = Attraction::approved()->forShowcase();

        $attraction->when($request->q, function ($query) use ($request) {
            $query->withTerm($request->q);
        });

        $attraction->when($request->municipality, function ($query) use ($request) {
            $query->where('location', 'like', "%{$request->municipality}%");
        });
        $attraction->when($request->category, function ($query) use ($request) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('attraction_categories.id', $request->category);
            });
        });
        $attraction->when($request->budget, function ($query) use ($request) {
            $query->where('budget_range_max', '<=', "%{$request->budget}%");
        });

        // $attraction->forShowcase()->paginate(6);

        // $laQuery = DB::getQueryLog();
        // dd($laQuery);

        return $attraction->paginate(6);
    }

    public function hasPerformedSearch()
    {
        $request = request();
        return !empty(array_filter(array_values($request->all(['q', 'category', 'municipality', 'budget']))));
    }
}
