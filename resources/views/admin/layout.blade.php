@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
  <a class="navbar-brand" href="{{ route('admin.dashboard') }}">{{ config('app.name') }} ADMIN</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Logged in as : ADMIN
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Logout</a>
        </div>
      </li>
    </ul>
  </div>
</nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">
          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ Route::is('admin.user.index') ? 'active' : '' }}" href="{{ route('admin.user.index') }}">Users </span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ Route::is('admin.attraction.index') ? 'active' : '' }}" href="{{ route('admin.attraction.index') }}">Attractions</a>
            </li>

          </ul>
           <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link {{ Route::is('admin.attraction-category.index') ? 'active' : '' }}" href="{{ route('admin.attraction-category.index') }}">Attraction Categories</a>
            </li>
          </ul>
        </nav>

        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
            <h1 class="row mb-3">
                <div class="col">@yield('title')</div>

                <div class="col text-right">
                  @if(MyHelper::resourceMethodIn(['create', 'edit']))
                    <a href="{{ MyHelper::resource('index') }}" class="btn btn-primary"><i class="fas fa-chevron-left"></i> Back to list</a>
                  @elseif(MyHelper::resourceMethodIn(['index']))
                    <a href="{{ MyHelper::resource('create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New entry</a>
                  @endif
                </div>

            </h1>
          @yield('body')
        </main>
      </div>
    </div>
@endsection
