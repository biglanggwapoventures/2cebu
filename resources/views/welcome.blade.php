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
   html{
    padding-bottom:50px;
   }
   a.action:hover {
    text-decoration: none;
   }
   form.flat input,select{
        border-radius: 0!important;
        box-shadow: none;
   }
   form.flat .form-group{
    margin-bottom: 5px;
   }
   form.flat .form-group label{
    margin-bottom: 3px;
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
    <div class="row pt-2 pb-3 rounded-bottom" style="background:#094754">
        <div class="col">
            <div class="container">
                <form class="text-white flat" action="{{ url()->current() }}">
                {!! Form::bsText('q', 'What are you looking for?') !!}
                  <div class="row mt-2">
                      <div class="col-sm-4 pr-sm-0 mb-xs-2">
                        {!! Form::bsSelect('municipality', 'Municipality', $provinces, null, ['class' => 'custom-select w-100']) !!}
                      </div>
                      <div class="col-sm-4 pl-sm-2 pr-sm-0  mb-xs-2">
                        {!! Form::bsSelect('category', 'Category', $categories, null,['class' => 'custom-select w-100']) !!}
                      </div>

                      <div class="col-sm-3  pl-sm-2 pr-sm-0  mb-xs-2">
                          {!! Form::bsNumber('budget', 'Max Budget', null, ['class' => 'form-control text-right', 'placeholder' => 'PHP']) !!}
                      </div>
                      <div class="pl-sm-2 col-sm-1">
                        <div class="hidden-xs">&nbsp;</div>
                        <button type="submit" class="btn btn-primary btn-block text-center mt-sm-1"><i class="fas fa-search"></i> </button>
                      </div>
                  </div>
                </form>
            </div>
        </div>
    </div>
    @if(!is_null($q))
    <div class="row pb-4" >
        <div class="col">
            <div class="container">
                <h3 class="mt-4 mb-4">Search Results <br><small>We found {{ $q->total() }} results from your search criteria!</small></h3>
                @forelse($q->chunk(3) as $chunk)
                <div class="row">
                    @foreach($chunk AS $searchResult)
                        <div class="col-sm-6 col-md-4 mb-2">
                            @include('components.attraction-showcase', ['item' => $searchResult])
                        </div>
                    @endforeach
                </div>
                @empty
                <p class="bg-danger p-3 text-white">No results found from your search criteria.</p>
                @endforelse
                {!! $q->appends(request()->all())->links() !!}
            </div>
        </div>
    </div>
     @endif
    <div class="row pb-4" style="background: #eee">
        <div class="col">
            <div class="container">
                <h3 class="mt-4 mb-4">Most Popular Spots <br><small>Spots that are rated by the community!</small></h3>
                @forelse($top->chunk(3) as $chunk)
                <div class="row">
                    @foreach($chunk AS $topResult)
                        <div class="col-sm-6 col-md-4 mb-2">
                            @include('components.attraction-showcase', ['item' => $topResult])
                        </div>
                    @endforeach
                </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="container">
                <h3 class="mt-4 mb-4">Newly Posted Spots <br><small>Most recent posted spots!</small></h3>
                 @forelse($newest->chunk(3) as $chunk)
                <div class="row">
                    @foreach($chunk AS $newestResult)
                        <div class="col-sm-6 col-md-4 mb-2">
                            @include('components.attraction-showcase', ['item' => $newestResult])
                        </div>
                    @endforeach
                </div>
                @empty
                @endforelse
            </div>
        </div>
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

    jQuery(document).ready(function($) {

    });
</script>
 <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBb9gjcZGig7KAgoJC1EmMHA98Rp8Ayz98&callback=initMap"></script>
@endpush
