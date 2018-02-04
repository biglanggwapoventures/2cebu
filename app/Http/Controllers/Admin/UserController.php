<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CRUDController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Session;

class UserController extends CRUDController
{
    public function __construct(User $model, Request $request)
    {
        parent::__construct();
        $this->resourceModel = $model;
        $this->validationRules = [
            'store' => [
                'firstname' => ['required'],
                'lastname' => ['required'],
                'contact_number' => ['required'],
                'address' => ['present'],
                'gender' => ['required', Rule::in(['male', 'female'])],
                'password' => 'required|min:6',
                'password_confirmation' => 'required|same:password',
                'email' => ['required', 'email', Rule::unique($model->getTable())],
                'username' => ['required', Rule::unique($model->getTable())],
            ],
            'update' => [
                'firstname' => ['required'],
                'lastname' => ['required'],
                'contact_number' => ['required'],
                'address' => ['present'],
                'gender' => ['required', Rule::in(['male', 'female'])],
                'password' => 'present|nullable|min:6',
                'password_confirmation' => 'present|nullable|same:password',
                'email' => ['required', 'email', Rule::unique($model->getTable())->ignore($request->route('user'))],
                'username' => ['required', Rule::unique($model->getTable())->ignore($request->route('user'))],
            ],
        ];
    }

    public function beforeIndex($query)
    {
        $request = request();

        $query->when(($name = $request->name), function ($query) use ($name) {
            return $query->whereRaw("CONCAT(firstname, ' ', lastname) LIKE '%{$name}%'");
        })->when(($email = $request->email), function ($query) use ($email) {
            return $query->where('email', '=', $email);
        });
    }

    public function beforeUpdate()
    {
        if (!trim(request()->password)) {
            unset($this->validatedInput['password']);
        }
    }

    public function afterStore($model)
    {
        Session::flash('growl', 'New user has been added.');
    }

    public function afterUpdate($model)
    {
        Session::flash('growl', 'User has been updated.');
    }
}
