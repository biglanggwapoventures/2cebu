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
                // 'attraction_status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
                'status_remarks' => ['sometimes'],
                'categories' => ['required', 'array'],
                'categories.*' => ['required', Rule::exists($category->getTable(), $category->getKeyName())],
                'tags' => ['present', 'nullable', 'array'],
            ],
            'update' => [
                'name' => ['required', Rule::unique($model->getTable())->ignore($request->route('attraction'))],
                'description' => ['required'],
                'location' => ['required'],
                'latitude' => ['required', 'numeric'],
                'longitude' => ['required', 'numeric'],
                'festivities' => ['present'],
                // 'attraction_status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
                'status_remarks' => ['sometimes'],
                'categories' => ['required', 'array'],
                'categories.*' => ['required', Rule::exists($category->getTable(), $category->getKeyName())],
                'tags' => ['present', 'nullable', 'array'],
            ],
        ];
    }

    public function beforeCreate()
    {
        $this->viewData['categoryList'] = AttractionCategory::select('id', 'description')->pluck('description', 'id');
        $this->viewData['tagList'] = Tag::pluck('description', 'description');
    }

    public function beforeEdit($model)
    {
        $model->load(['categories', 'tags', 'accomodations', 'transportations', 'activities', 'delicacies']);
        $model->accomodations = $model->accomodations->isEmpty() ? collect([new Accomodation]) : $model->accomodations;
        $model->transportations = $model->transportations->isEmpty() ? collect([new Transportation]) : $model->transportations;
        $model->delicacies = $model->delicacies->isEmpty() ? collect([new Delicacy]) : $model->delicacies;
        $model->activities = $model->activities->isEmpty() ? collect([new Activity]) : $model->activities;
        if ($model->photos->count() < 5) {
            $model->photos = $model->photos->pad(5, new Photo());
        }
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
    }

    public function afterUpdate($attraction)
    {
        $attraction->categories()->sync(request()->categories);
        $tags = collect(request()->tags)->map(function ($item) {
            $tag = Tag::firstOrCreate(['description' => $item]);
            return $tag->id;
        });
        $attraction->tags()->sync($tags);
    }

    public function beforeStore()
    {
        $this->validationInput['attraction_status'] = 'approved';
    }

    public function beforeUpdate()
    {
        $this->validationInput['attraction_status'] = 'approved';
    }
}
