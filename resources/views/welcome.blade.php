@extends('layouts.main')

@push('css')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
@endpush

@section('content')
    @include('main-navbar')
    @if($hasPerformedSearch)
    <div class="row" >
        <div class="col">
            <div id="map"></div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    @foreach($featured AS $feature)
                        <li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->iteration }}"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22800%22%20height%3D%22400%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20800%20400%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_161288a8f50%20text%20%7B%20fill%3A%23444%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A40pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_161288a8f50%22%3E%3Crect%20width%3D%22800%22%20height%3D%22400%22%20fill%3D%22%23666%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22247.3203125%22%20y%3D%22218.45%22%3ESecond%20slide%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E"  alt="First slide">
                    </div>
                    @foreach($featured AS $feature)
                    <div class="carousel-item" style="background: url('{{ $feature->feature_banner  }}') center center;background-size: cover;background-repeat: no-repeat;">
                        <div class="carousel-caption d-none d-md-block">
                            <h5 class="d-inline-block"><a class="text-white" href="{{ route('user.attraction.show', ['id' => $feature->id]) }}">{{ $feature->name }}</a></h5>
                            <br>
                            <p class="d-inline-block">{{ $feature->location }}</p>
                          </div>
                    </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>

    @endif
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
                            @include('components.attraction-showcase', ['item' => $searchResult, 'onMap' => true])
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
    function initMap() {

        var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: {
                    lat: 10.31672,
                    lng: 123.8907
                },
            }),
            markerIcon = {
                path: 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z',
                fillColor: '#e25a00',
                fillOpacity: 0.95,
                scale: 3,
                strokeColor: '#fff',
                strokeWeight: 3,
                anchor: new google.maps.Point(12, 24)
            };

        var attractions = $('.attraction');

        if(attractions.length){
            attractions.each(function (v, i) {
                var coords = {
                    lat: parseFloat($(this).data('latitude')),
                    lng: parseFloat($(this).data('longitude'))
                },
                title = $(this).data('title'),
                marker = new google.maps.Marker({
                    position: coords,
                    map: map,
                    title: title,
                    icon: markerIcon
                }),
                infoWindow = new google.maps.InfoWindow({
                    maxWidth: 350,
                    content: $(this)[0].outerHTML
                });

                marker.addListener('click', function() {
                  infoWindow.open(map, marker);
                });

                google.maps.event.addListener(map, 'click', function() {
                    infoWindow.close();
                });

                google.maps.event.addListener(infoWindow, 'domready', function() {
                    var iwOuter = $('.gm-style-iw');
                    var iwBackground = iwOuter.prev();

    // Removes background shadow DIV
                    iwBackground.children(':nth-child(2)').css({'display' : 'none'});

                    // Removes white background DIV
                    iwBackground.children(':nth-child(4)').css({'display' : 'none'});

                });
            })
        }
    }
</script>
 <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBb9gjcZGig7KAgoJC1EmMHA98Rp8Ayz98&callback=initMap"></script>
@endpush
