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
        font-size: 13px;
        margin-bottom:2px;
    }
    .card.profile .form-group {
        margin-bottom: 7px;
    }
</style>
@endpush
@section('content')
    @include('main-navbar')
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="card profile mt-4">
                    <div class="card-body p-3">
                        {!! Form::model(auth()->user(), ['url' => route('user.profile.update'), 'method' => 'patch', 'class' => 'ajax']) !!}
                            {!! Form::bsText('username', 'Username', null, ['class' => 'form-control-plaintext', 'readonly' => true]) !!}
                            {!! Form::bsText('firstname', 'First Name', null, ['class' => 'form-control form-control-sm']) !!}
                            {!! Form::bsText('lastname', 'Last Name', null, ['class' => 'form-control form-control-sm']) !!}
                            {!! Form::bsText('email', 'Email Address', null, ['class' => 'form-control form-control-sm']) !!}
                            {!! Form::bsSelect('gender', 'Gender', ['' => '', 'male' => 'Male', 'female' => 'Female'], null, ['class' => 'custom-select custom-select-sm w-100']) !!}
                            {!! Form::bsText('contact_number', 'Contact Number', null, ['class' => 'form-control form-control-sm']) !!}
                            <hr>
                            {!! Form::bsPassword('password', 'Password', ['class' => 'form-control form-control-sm']) !!}
                            {!! Form::bsPassword('password_confirmation', 'Confirm Password', ['class' => 'form-control form-control-sm']) !!}
                            <hr>
                            <button type="submit" class="btn btn-success btn-block">Save</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <h3 class="mt-4 pb-2">My Favorites {{ $favorites->total() ? "(".$favorites->total().")" : '' }}</h3>
                <ul class="list-unstyled">
                    @forelse($favorites as $item)
                        <li class="media mb-2 ">
                            <a href="{{ route('user.attraction.show', ['attraction' => $item->id]) }}">
                                <img class="mr-3 rounded" src="{{$item->thumbnail? $item->thumbnail->filepath : MyHelper::photoPlaceholder()}}" alt="{{ $item->name }}" style="height:80px; width: 80px;">
                            </a>
                            <div class="media-body  text-truncate">
                                <a href="{{ route('user.attraction.show', ['attraction' => $item->id]) }}">
                                    <h5 class="mt-0 mb-1">{{ $item->name }} </h5>
                                </a>
                                <p class="text-truncate mb-0">{{ $item->location }}</p>
                                 <span class="text-success">{{ $item->average_rating ?: 0 }} <i class="fas fa-star "></i> </span>
                            </div>
                        </li>
                    @empty
                    <p class="bg-warning p-3">No liked attractions.</p>
                    @endforelse
                </ul>
                {{ $favorites->links() }}
            </div>
            <div class="col-sm-4">
                <h3 class="mt-4 pb-2">My Reviews</h3>
                @forelse($reviews as $item)
                    <blockquote class="blockquoter">
                        <p class="mb-0 clearfix">
                            {!! $item->review ?: '<em class="text-danger">Empty</em> ' !!}
                            <small class="text-success float-right">{{ $item->rating ?: 0 }} <i class="fas fa-star"></i> </small>
                        </p>
                        <footer class="blockquote-footer">{{ $item->attraction->name }}, <cite>{{ date_create($item->created_at)->format('m/d/Y h:i a') }}</cite> </footer>
                    </blockquote>
                    <hr>
                 @empty
                <p class="bg-warning p-3">No reviews given</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
