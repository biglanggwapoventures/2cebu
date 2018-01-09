@extends('layouts.main')

@push('css')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<style>
   #map {
    height: 500px;
    width: 100%;
   }
   .table .form-group{
    margin-bottom:0;
   }
</style>
@endpush

@section('content')
    @include('main-navbar')


    <div class="row" >
        <div class="col">
            <div id="map"></div>
        </div>
    </div>
    <div class="container">
        <div class="row pt-3 bg-primary pb-3 rounded-bottom">
            <div class="col">
                <form>
                {!! Form::text('search', null, ['class' => 'form-control w-100', 'placeholder' => 'What are you looking for?']) !!}
                  <div class="row mt-2">
                      <div class="col-3">
                        {!! Form::text('search', null, ['class' => 'form-control w-100', 'placeholder' => 'Filter by province']) !!}
                      </div>
                      <div class="col-3">
                        {!! Form::text('search', null, ['class' => 'form-control w-100', 'placeholder' => 'Filter by category']) !!}
                      </div>
                      <div class="col-3">
                        {!! Form::text('search', null, ['class' => 'form-control w-100', 'placeholder' => 'Filter by tags']) !!}
                      </div>
                      <div class="col-3">
                        <button type="submit" class="btn btn-success btn-block"><i class="fas fa-search"></i> Explore</button>
                      </div>
                  </div>

                </form>
            </div>
        </div>
        <h3 class="mt-4 mb-4 text-center"><i class="fas fa-star"></i> Most Popular Spots</h4>
         @foreach($data->chunk(3) as $chunk)
            <div class="row">
                @foreach($chunk as $item)
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="card-text">{{ $item->location }}</p>
                            </div>
                            <div style="height:200px;background:url({{$item->photos[0]->filepath}}) center center;background-size: cover" alt="{{ $item->name }}"></div>
                            <div class="card-body">
                                <a href="#" class="card-link text-dark"><i class="fas fa-heart"></i> Like</a>
                                <a href="#" class="card-link"><i class="fas fa-star"></i> 4.5 </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection


@push('js')

<script>
    function getDefaultMapCenter() {
        var defaultLat = 10.3157,
            defaultLng =  123.8854;

        return {
            lat: defaultLat,
            lng: defaultLng
        }
    }
    function initMap() {

        var geocoder = new google.maps.Geocoder,
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: getDefaultMapCenter()
            })
    }
</script>
 <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBb9gjcZGig7KAgoJC1EmMHA98Rp8Ayz98&callback=initMap"></script>
@endpush
