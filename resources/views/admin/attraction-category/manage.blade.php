@extends('admin.layout')
@section('title', 'Attraction Categories')
@section('body')
@if(is_null($resourceData->id))
{!! Form::open(['url' => MyHelper::resource('store'), 'method' => 'POST']) !!}
@else
{!! Form::model($resourceData, ['url' => MyHelper::resource('update', ['id' => $resourceData->id]), 'method' => 'PATCH']) !!}
@endif

<div class="row">
    <div class="col-6">
        {!! Form::bsText('description', 'Description') !!}
        <hr>
        <button type="submit" class="btn btn-success">Save</button>
    </div>
</div>


{!! Form::close() !!}
@endsection
