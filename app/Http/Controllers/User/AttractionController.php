<?php

namespace App\Http\Controllers\User;

use App\Accomodation;
use App\Activity;
use App\Attraction;
use App\AttractionCategory;
use App\Delicacy;
use App\Http\Controllers\CRUDController;
use App\Photo;
use App\Tag;
use App\Transportation;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Session;

class AttractionController extends CRUDController
{
    public function __construct(
        Attraction $model,
        Request $request,
        AttractionCategory $category,
        Tag $tag
    ) {
        $this->middleware('auth', ['except' => 'show']);
        parent::__construct();
        $this->resourceModel = $model;
        $this->validationRules = [
            'store' => [
                'name' => ['required', Rule::unique($model->getTable())],
                'description' => ['required'],
                'location' => ['required'],
                'latitude' => ['required', 'numeric'],
                'longitude' => ['required', 'numeric'],
                'festivities' => ['present'],
                'policy' => ['present'],
                // 'attraction_status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
                'status_remarks' => ['sometimes'],
                'categories' => ['required', 'array'],
                // 'categories.*' => ['required', Rule::exists($category->getTable(), $category->getKeyName())],
                'tags' => ['present', 'nullable', 'array'],
                'budget_range_min' => ['required', 'numeric'],
                'budget_range_max' => ['required', 'numeric'],
            ],
            'update' => [
                'name' => ['required', Rule::unique($model->getTable())->ignore($request->route('attraction'))],
                'description' => ['required'],
                'location' => ['required'],
                'latitude' => ['required', 'numeric'],
                'longitude' => ['required', 'numeric'],
                'festivities' => ['present'],
                'policy' => ['present'],
                // 'attraction_status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
                'status_remarks' => ['sometimes'],
                'categories' => ['required', 'array'],
                // 'categories.*' => ['required', Rule::exists($category->getTable(), $category->getKeyName())],
                'tags' => ['present', 'nullable', 'array'],
                'budget_range_min' => ['required', 'numeric'],
                'budget_range_max' => ['required', 'numeric'],
            ],
        ];
    }

    public function beforeIndex($query)
    {
        $query->ownedBy(Auth::id())->with('photos');
    }

    public function beforeCreate()
    {
        $this->viewData['categoryList'] = AttractionCategory::pluck('description', 'description');
        $this->viewData['tagList'] = Tag::pluck('description', 'description');
    }

    public function beforeEdit($model)
    {
        $model->accomodations->when($model->accomodations->isEmpty(), function ($accomodations) {
            return $accomodations->push(new Accomodation);
        });
        $model->transportations->when($model->transportations->isEmpty(), function ($transportations) {
            return $transportations->push(new Transportation);
        });
        $model->delicacies->when($model->delicacies->isEmpty(), function ($delicacies) {
            return $delicacies->push(new Delicacy);
        });
        $model->activities->when($model->activities->isEmpty(), function ($activities) {
            return $activities->push(new Activity);
        });
        $model->photos->when($model->photos->count() < 5, function ($photos) use ($model) {
            $model->photos = $photos->pad(5, new Photo);
        });

        $reviewStatus = in_array(request()->review_status, ['pending', 'approved', 'rejected']) ? request()->review_status : 'pending';
        // dd($reviewStatus);
        $model->load(['reviews' => function ($query) use ($reviewStatus) {
            return $query->with('owner')->whereRatingStatus($reviewStatus);
        }]);
        $this->beforeCreate();
    }

    public function afterStore($attraction)
    {
        $tags = collect(request()->tags)->map(function ($item) {
            $tag = Tag::firstOrCreate(['description' => $item]);
            return $tag->id;
        });
        $categories = collect(request()->categories)->map(function ($item) {
            $category = AttractionCategory::firstOrCreate(['description' => $item]);
            return $category->id;
        });
        $attraction->categories()->attach($category);
        $attraction->tags()->attach($tags);
        Session::flash('growl', 'Attraction successfully added. You can now manage the accomodations, transportation and more details.');
    }

    public function afterUpdate($attraction)
    {
        $tags = collect(request()->tags)->map(function ($item) {
            $tag = Tag::firstOrCreate(['description' => $item]);
            return $tag->id;
        });
        $categories = collect(request()->categories)->map(function ($item) {
            $category = AttractionCategory::firstOrCreate(['description' => $item]);
            return $category->id;
        });
        $attraction->categories()->sync($categories);
        $attraction->tags()->sync($tags);
        Session::flash('growl', 'Attraction successfully updated');
    }

    public function beforeStore()
    {
        $this->validatedInput['user_id'] = Auth::id();
        $this->validatedInput['attraction_status'] = 'pending';
    }

    public function beforeShow($attraction)
    {
        $attraction->load(['accomodations', 'activities', 'transportations', 'delicacies', 'owner', 'tags', 'photos', 'approvedReviews.owner']);
        $attraction->photos->when($attraction->photos->count() < 5, function ($photos) use ($attraction) {
            $attraction->photos = $photos->pad(5, new Photo);
        });
    }
}
