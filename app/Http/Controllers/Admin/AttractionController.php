<?php

namespace App\Http\Controllers\Admin;

use App\Accomodation;
use App\Activity;
use App\Attraction;
use App\AttractionCategory;
use App\Delicacy;
use App\Http\Controllers\CRUDController;
use App\Photo;
use App\Tag;
use App\Transportation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Session;

class AttractionController extends CRUDController
{
    public function __construct(Attraction $model, Request $request, AttractionCategory $category, Tag $tag)
    {
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
                'budget_range_min' => ['required', 'numeric'],
                'budget_range_max' => ['required', 'numeric'],
                'policy' => ['present'],
                'attraction_status' => ['sometimes', Rule::in(['pending', 'approved', 'rejected'])],
                'status_remarks' => ['sometimes'],
                'categories' => ['required', 'array'],
                'categories.*' => ['required', Rule::exists($category->getTable(), $category->getKeyName())],
                'tags' => ['present', 'nullable', 'array'],
                'is_featured' => 'boolean',
                'feature_banner' => 'required_if:is_featured,1|image',
            ],
            'update' => [
                'name' => ['required', Rule::unique($model->getTable())->ignore($request->route('attraction'))],
                'description' => ['required'],
                'location' => ['required'],
                'latitude' => ['required', 'numeric'],
                'longitude' => ['required', 'numeric'],
                'festivities' => ['present'],
                'budget_range_min' => ['required', 'numeric'],
                'budget_range_max' => ['required', 'numeric'],
                'policy' => ['present'],
                'attraction_status' => ['sometimes', Rule::in(['pending', 'approved', 'rejected'])],
                'status_remarks' => ['sometimes'],
                'categories' => ['required', 'array'],
                'categories.*' => ['required', Rule::exists($category->getTable(), $category->getKeyName())],
                'tags' => ['present', 'nullable', 'array'],
                'is_featured' => 'boolean',
                'feature_banner' => 'image',
            ],
        ];
    }

    public function beforeIndex($query)
    {
        request()->validate([
            'name' => 'nullable',
            'location' => 'nullable',
            'category' => ['nullable'],
            'status' => ['nullable', Rule::in(['pending', 'approved', 'rejected'])],
        ]);

        extract(request()->all(['name', 'location', 'category', 'status']));
        // unset()

        $query->when($name, function ($query) use ($name) {
            $query->nameLike($name);
        })->when($location, function ($query) use ($location) {
            $query->locationLike($location);
        })->when($category, function ($query) use ($category) {
            $query->withCategory($category);
        })->when($status, function ($query) use ($status) {
            $query->ofStatus($status);
        });

        $this->viewData['categories'] = AttractionCategory::dropdownFormat();
        $query->with('owner')->featuredFirst();
    }

    public function beforeCreate()
    {
        $this->viewData['categoryList'] = AttractionCategory::select('id', 'description')->pluck('description', 'id');
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
        $model->load(['reviews' => function ($query) use ($reviewStatus) {
            return $query->with('owner')->whereRatingStatus($reviewStatus);
        }]);
        $this->beforeCreate();
    }

    public function afterStore($attraction)
    {
        $attraction->categories()->attach(request()->categories);
        $tags = collect(request()->tags)->map(function ($item) {
            $tag = Tag::firstOrCreate(['description' => $item]);
            return $tag->id;
        });
        $attraction->tags()->attach($tags);
        Session::flash('growl', 'Attraction successfully added. You can now manage the accomodations, transportation and more details.');
    }

    public function afterUpdate($attraction)
    {
        $attraction->categories()->sync(request()->categories);
        $tags = collect(request()->tags)->map(function ($item) {
            $tag = Tag::firstOrCreate(['description' => $item]);
            return $tag->id;
        });
        $attraction->tags()->sync($tags);

        Session::flash('growl', 'Attraction successfully updated');
    }

    public function beforeStore()
    {
        $this->validatedInput['feature_banner'] = $this->storeFeatureBanner();
        $this->validatedInput['attraction_status'] = 'approved';
    }

    public function beforeUpdate()
    {
        if (!request()->is_featured) {
            $this->validatedInput['is_featured'] = 0;
        } elseif (request()->is_featured && ($requestBanner = $this->storeFeatureBanner())) {
            $this->validatedInput['feature_banner'] = $requestBanner;
        }
    }

    private function storeFeatureBanner()
    {
        if ((int) request()->is_featured && request()->hasFile('feature_banner')) {
            return request()->file('feature_banner')->store(
                'photos/feature-banners', 'public'
            );
        }
        return null;
    }
}
