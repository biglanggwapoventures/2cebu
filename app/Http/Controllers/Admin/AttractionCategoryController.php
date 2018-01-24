<?php

namespace App\Http\Controllers\Admin;

use App\AttractionCategory;
use App\Http\Controllers\CRUDController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Session;

class AttractionCategoryController extends CRUDController
{
    public function __construct(AttractionCategory $model, Request $request)
    {
        parent::__construct();
        $this->resourceModel = $model;
        $this->validationRules = [
            'store' => [
                'description' => ['required', Rule::unique($model->getTable())],
            ],
            'update' => [
                'description' => ['required', Rule::unique($model->getTable())->ignore($request->route('attraction_category'))],
            ],
        ];
    }

    public function afterStore($model)
    {
        Session::flash('growl', 'A new category has been added.');
    }

    public function afterUpdate($model)
    {
        Session::flash('growl', 'Category successfully updated.');
    }
}
