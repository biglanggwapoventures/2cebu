@extends('layouts.main')

@push('css')
<link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/css-stars.css') }}">
<link rel="stylesheet" href="{{ asset('fontawesome4/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/fontawesome-stars-o.css') }}">

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
   #map {
        height:100%;
        width: 100%;
   }
</style>
@endpush



@section('content')
    @include('main-navbar')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5 col-sm-12 p-0 h-100" style="overflow:hidden;">
                <div class="row">
                    @foreach($resourceData->photos AS $photo)
                        <div class="col p-0" style="height:100px;background: url('{{ $photo->filepath  }}') center center;background-size: cover;background-repeat: no-repeat;">
                            <a class="d-block h-100" data-fancybox="gallery"  href="{{ $photo->filepath }}">&nbsp;</a>
                        </div>
                    @endforeach
                </div>
                <div id="map"></div>
            </div>
            <div class="col-md-7 col-sm-12" style="overflow-y:scroll">
                {!! Form::hidden('longitude', $resourceData->longitude) !!}
                {!! Form::hidden('latitude', $resourceData->latitude) !!}
                <h3 class="pb-3 position-sticky pt-2 bg-white w-100" style="border-bottom:2px solid #eee;top:0;z-index: 5">
                    {{ $resourceData->name }}
                    <small class="d-block mb-1">
                        {{ $resourceData->location }}
                    </small>
                    <div class="row align-content-center">
                         <div class="col-1">
                             <small class="text-success">[{{ $resourceData->average_rating }}]</small>
                        </div>
                        <div class="col-2">
                            {!! Form::select('', ['1' => '1','2' => '2','3' => '3','4' => '4','5' => '5'], null, ['class' => 'average-rating', 'data-default' => $resourceData->average_rating]) !!}
                        </div>

                    </div>

                </h3>
                <dl class="row">
                    <dt class="col-sm-3">Category</dt>
                    <dd class="col-sm-9 mb-0">{{ $resourceData->categories->implode('description', ', ') }}</dd>
                    <dt class="col-sm-3">Budget Range</dt>
                    <dd class="col-sm-9 mb-0">{{ number_format($resourceData->budget_range_min, 2) }} to {{ number_format($resourceData->budget_range_max, 2) }} php</dd>
                    <dt class="col-sm-3">Tags</dt>
                    <dd class="col-sm-9 mb-0">{{ $resourceData->tags->implode('description', ', ') }}</dd>
                    <dt class="col-sm-3">Published by</dt>
                    <dd class="col-sm-9 mb-0">{{ $resourceData->owner->fullname }}</dd>
                </dl>
                <p class="" style="white-space: pre-wrap;">{{ $resourceData->description }}</p>
                <ul class="nav nav-tabs justify-content-center mt-3" id="myTab" role="tablist">
                  <li>
                    <a class="nav-link active text-center" id="festivities-tab" data-toggle="tab" href="#festivities" role="tab" aria-controls="festivities" aria-selected="true">
                        <i class="fas fa-asterisk fa-2x d-block"></i>Festivities
                    </a>
                  </li>
                  <li>
                    <a class="nav-link text-center" id="policies-tab" data-toggle="tab" href="#policies" role="tab" aria-controls="policies" aria-selected="true">
                       <i class="fas fa-shield-alt fa-2x d-block"></i> Policies
                    </a>
                  </li>
                  <li>
                    <a class="nav-link text-center" id="accomodations-tab" data-toggle="tab" href="#accomodations" role="tab" aria-controls="accomodations">
                       <i class="fas fa-home fa-2x d-block"></i> Accomodations
                    </a>
                  </li>
                  <li>
                    <a class="nav-link text-center" id="transpo-tab" data-toggle="tab" href="#transpo" role="tab" aria-controls="transpo" >
                        <i class="fas fa-motorcycle fa-2x d-block"></i> Transportation
                    </a>
                  </li>
                  <li>
                    <a class="nav-link text-center" id="activities-tab" data-toggle="tab" href="#activities" role="tab" aria-controls="activities">
                        <i class="fas fa-tasks fa-2x d-block"></i> Activities
                    </a>
                  </li>
                  <li>
                    <a class="nav-link text-center" id="delicacies-tab" data-toggle="tab" href="#delicacies" role="tab" aria-controls="delicacies">
                        <i class="fas fa-utensils fa-2x d-block"></i> Delicacies
                    </a>
                  </li>
                  <li>
                    <a class="nav-link text-center" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews">
                        <i class="fas fa-star fa-2x d-block"></i> Reviews
                    </a>
                  </li>
                </ul>
                <div class="tab-content mt-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="festivities" role="tabpanel" aria-labelledby="festivities-tab">
                        <p style="white-space: pre-wrap;">{{ $resourceData->festivities }}</p>
                    </div>
                    <div class="tab-pane" id="policies" role="tabpanel" aria-labelledby="policies-tab">
                        <p style="white-space: pre-wrap;">{{ $resourceData->policy }}</p>
                    </div>
                    <div class="tab-pane" id="accomodations" role="tabpanel" aria-labelledby="accomodations-tab">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th class="bg-success text-white">Description</th>
                                    <th class="bg-success text-white">Minimum Rate</th>
                                    <th class="bg-success text-white">Max Rate</th>
                                    <th class="bg-success text-white">Additional Information</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($resourceData->accomodations AS $accomodation)
                                <tr>
                                    <td>{{ $accomodation->description }}</td>
                                    <td class="text-right">{{ number_format($accomodation->min_rate, 2) }}</td>
                                    <td class="text-right">{{ number_format($accomodation->max_rate, 2) }}</td>
                                    <td>{{ $accomodation->remarks }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Nothing to show</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="transpo" role="tabpanel" aria-labelledby="transpo-tab">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th class="bg-success text-white">Vehicle</th>
                                    <th class="bg-success text-white">Start Point</th>
                                    <th class="bg-success text-white">End Point</th>
                                    <th class="bg-success text-white">Cost</th>
                                    <th class="bg-success text-white"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($resourceData->transportations AS $transpo)
                                <tr>
                                    <td>{{ $transpo->description }}</td>
                                    <td>{{ $transpo->start_point }}</td>
                                    <td>{{ $transpo->end_point }}</td>
                                    <td>{{ number_format($transpo->fare, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Nothing to show</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="activities" role="tabpanel" aria-labelledby="activities-tab">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th class="bg-success text-white">Type of Activity</th>
                                    <th class="bg-success text-white">Cost</th>
                                    <th class="bg-success text-white">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($resourceData->activities AS $activity)
                                <tr>
                                    <td>{{ $activity->description }}</td>
                                    <td>{{ number_format($activity->cost, 2) }}</td>
                                    <td>{{ $activity->remarks }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Nothing to show</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="delicacies" role="tabpanel" aria-labelledby="delicacies-tab">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th class="bg-success text-white">Name</th>
                                    <th class="bg-success text-white">Cost</th>
                                    <th class="bg-success text-white">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($resourceData->delicacies AS $delicacy)
                                <tr>
                                    <td>{{ $delicacy->description }}</td>
                                    <td>{{ number_format($delicacy->cost, 2) }}</td>
                                    <td>{{ $delicacy->remarks }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Nothing to show</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="row">
                            <div class="col-4">
                                @auth
                                    @if(($myRating = auth()->user()->lastReview($resourceData)) && !$myRating->isWeekOld())
                                        <div class="card card-body">
                                            <h4 class="card-tite">Your rating</h4>
                                            <div class="form-group">
                                                {!! Form::select('', ['1' => '1','2' => '2','3' => '3','4' => '4','5' => '5'], $myRating->rating, ['class' => 'rating-readonly']) !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="mb-0">You wrote:</label>
                                                <p class="form-control-static">
                                                    <strong>{!! $myRating->review ? $myRating->review : '<em >No review</em>' !!}</strong>
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="mb-0">Submitted at:</label>
                                                <p class="form-control-static">
                                                    {!! date_create($myRating->created_at)->format('m/d/Y h:i A') !!}
                                                </p>
                                            </div>
                                            <p class="text-primary">Thank you for your feedback!</p>
                                        </div>
                                    @else
                                        {!! Form::open(['url' => route('user.review', ['attractionId' => $resourceData->id]), 'method' => 'post', 'class' => 'ajax']) !!}
                                            <div class="form-group">
                                                <label class="mb-0">Rate this attraction</label>
                                                {!! Form::select('rating', ['1' => '1','2' => '2','3' => '3','4' => '4','5' => '5'], null, ['class' => 'rating']) !!}
                                            </div>
                                            {!! Form::bsTextarea('review', 'Give a feedback!', null, ['rows' => 3]) !!}
                                            <button type="submit" class="btn btn-success">Submit your review!</button>
                                        {!! Form::close() !!}
                                    @endif
                                @endauth
                                @guest
                                    <p class="bg-danger p-2 text-center text-white">
                                        You need to create an account to submit a review. Click <a class="text-info" href="#" data-toggle="modal" data-target="#register">here</a> to create one.
                                    </p>
                                @endguest
                            </div>
                            <div class="col">
                                @forelse($resourceData->approvedReviews AS $review)
                                    <blockquote class="blockquote">
                                        <p class="mb-0">
                                            {!! Form::select('', ['1' => '1','2' => '2','3' => '3','4' => '4','5' => '5'], $review->rating, ['class' => 'rating-readonly']) !!}
                                        </p>
                                        <p class="mb-0">{!! $review->review ?: '<small class="text-danger"><em>Empty</em></small>' !!}</p>
                                        <footer class="blockquote-footer">{{ $review->owner->fullname }} <cite>{!! date_create($review->created_at)->format('m/d/Y h:i A') !!}</cite></footer>
                                    </blockquote>
                                    <hr>
                                @empty
                                    <div class="alert alert-info text-center">
                                        <i class="fas fa-frown fa-2x d-block mb-1"></i>
                                        <p class="mb-0">No reviews available. Be the first to submit!</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection


@push('js')
<script type="text/javascript" src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.barrating.min.js') }}"></script>
<script type="text/javascript">
    function getDefaultMapCenter() {
        var defaultLat = parseFloat($('[name=latitude]').val()) ||  10.3157,
            defaultLng =  parseFloat($('[name=longitude]').val()) ||  123.8854;

        return {
            lat: defaultLat,
            lng: defaultLng
        }
    }
    function initMap() {

        var geocoder = new google.maps.Geocoder,
            map = new google.maps.Map(document.getElementById('map'), {
                // mapTypeId: 'satellite',
                zoom: 12,
                center: getDefaultMapCenter(),
                // draggable:false
            }),
            marker = new google.maps.Marker({
                map: map,
                position: getDefaultMapCenter()
            });
    }

    jQuery(document).ready(function($) {
        $('.average-rating').barrating({
            theme: 'fontawesome-stars-o',
            initialRating: $('.average-rating').data('default'),
            readonly: true,
        });
        $('.rating').barrating({
            theme: 'css-stars'
        });
        $('.rating-readonly').barrating({
            theme: 'css-stars',
            readonly: true,
        });
    });
</script>

 <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBb9gjcZGig7KAgoJC1EmMHA98Rp8Ayz98&callback=initMap">
    </script>
@endpush
