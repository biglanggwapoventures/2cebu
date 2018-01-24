@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<style>
    body{
        padding-top: 59px;
    }
   html, body,.container-fluid > .row:first-child {
        height: 100%;
   }
    .container-fluid {
        height: 100%;
    }
    .card.profile .form-group label{
        font-weight: bold;
    }
</style>
@endpush
@section('content')
    @include('main-navbar')
    <div class="container">
        <h3 class="mt-4 pb-2">My Profile</h3>
        <div class="row">
            <div class="col-sm-4">
                <div class="card profile">
                    <div class="card-body">
                        {!! Form::model(auth()->user(), []) !!}
                            {!! Form::bsText('username', 'Username', null, ['class' => 'form-control-plaintext', 'readonly' => true]) !!}
                            {!! Form::bsText('firstname', 'First Name') !!}
                            {!! Form::bsText('lastname', 'Last Name') !!}
                            {!! Form::bsText('email', 'Email Address') !!}
                            {!! Form::bsSelect('gender', 'Gender', ['' => '', 'male' => 'Male', 'female' => 'Female'], null, ['class' => 'custom-select w-100']) !!}
                            {!! Form::bsText('contact_number', 'Contact Number') !!}
                            <button type="submit" class="btn btn-success btn-block">Save</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                @each('components.attraction-showcase', $favorites, 'item')
            </div>
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-header">My Reviews and Ratings</div>
                    <div class="card-body"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
