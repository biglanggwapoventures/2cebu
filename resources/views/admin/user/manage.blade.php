@extends('admin.layout')
@section('title', 'Users')

@section('body')
@if(is_null($resourceData->id))
{!! Form::open(['url' => MyHelper::resource('store'), 'method' => 'POST']) !!}
@else
{!! Form::model($resourceData, ['url' => MyHelper::resource('update', ['id' => $resourceData->id]), 'method' => 'PATCH']) !!}
@endif

<div class="row">
    <div class="col-4">
        {!! Form::bsText('email', 'Email Address') !!}
        {!! Form::bsText('username', 'Username') !!}
        <div class="row">
            <div class="col">
                {!! Form::bsPassword('password', 'Desired Password') !!}
            </div>
            <div class="col">
                {!! Form::bsPassword('password_confirmation', 'Password, Again') !!}
            </div>
        </div>
    </div>
    <div class="col-5">
        <div class="row">
            <div class="col">
                {!! Form::bsText('firstname', 'First Name') !!}
            </div>
            <div class="col">
                {!! Form::bsText('lastname', 'Last Name') !!}
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                {!! Form::bsSelect('gender', 'Gender', ['' => '', 'male' => 'Male', 'female' => 'Female']) !!}
            </div>
            <div class="col">
                {!! Form::bsText('contact_number', 'Contact Number') !!}
            </div>
        </div>
        {!! Form::bsTextarea('address', 'Address', null, ['rows' => 4]) !!}
    </div>
</div>
<hr>
<button type="submit" class="btn btn-success">Save</button>

{!! Form::close() !!}
@endsection
