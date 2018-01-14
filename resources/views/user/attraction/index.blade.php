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
</style>
@endpush
@section('content')
    @include('main-navbar')
    <div class="container">
        <div class="row">
            <div class="col">
                <h3 class="mt-2 pb-2" style="border-bottom:1px solid #eee">My Submissions
                    <small class="float-right"><a  href="{{ MyHelper::resource('create') }}"><i class="fas fa-plus"></i> Submit new attraction</a></small>
                </h3>
                @if($resourceList->isEmpty())
                <div class="alert alert-warning" role="alert">
                  <h4 class="alert-heading">Uh oh!</h4>
                  <p>Woah, 0 submissions? Contribute by submitting an attraction! Click the button below to start!</p>
                  <hr>
                  <p class="mb-0"><a href="{{ MyHelper::resource('create') }}" class="btn btn-success">New submission</a></p>
                </div>
                @else
                <p class="lead">
                    You have a total of <strong>{{ $resourceList->count() }}</strong> submissions:
                    <span class="badge badge-pill badge-success">{{ $resourceList->where('attraction_status', 'approved')->count() }} Approved</span>
                    <span class="badge badge-pill badge-secondary">{{ $resourceList->where('attraction_status', 'pending')->count() }} Pending</span>
                    <span class="badge badge-pill badge-primary">{{ $resourceList->where('attraction_status', 'rejected')->count() }} Rejected</span>
                </p>
                <div class="row mt-5">
                    <div class="col">
                        <div class="row">
                            @foreach($resourceList->split(3) as $group)
                                <div class="col-4">
                                    @foreach($group as $item)
                                        <div class="card">

                                            <div class="card-body p-3">
                                                <h5 class="card-title mb-0"><a href="{{ MyHelper::resource('edit', ['attraction' => $item->id]) }}">{{ $item->name }}</a></h5>
                                                <p class="card-text text-truncate">{{ $item->location }}</p>
                                            </div>
                                            <div style="height:200px;background:url('{{$item->thumbnail ? $item->thumbnail->filepath : MyHelper::photoPlaceholder()}}') center center;background-size: cover" alt="{{ $item->name }}"></div>
                                            <div class="card-body p-3">
                                                <p class="card-text">
                                                    <small class="text-muted d-block">Submitted: {{ date_create($item->created_at)->format('m/d/Y h:i A') }}</small>
                                                    <small class="text-muted d-block">Last updated: {{ date_create($item->created_at)->format('m/d/Y h:i A') }}</small>
                                                </p>
                                            </div>
                                            @if($item->is('approved'))
                                            <div class="card-footer text-white bg-success text-center pl-3 pr-3 pt-1 pb-1"><i class="fas fa-check"></i> Approved</div>
                                            @elseif($item->is('rejected'))
                                            <div class="card-footer text-white bg-primary text-center pl-3 pr-3 pt-1 pb-1"><i class="fas fa-times"></i> Rejected</div>
                                            @else
                                            <div class="card-footer text-white bg-secondary text-center pl-3 pr-3 pt-1 pb-1"><i class="fas fa-clock"></i> Pending</div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
