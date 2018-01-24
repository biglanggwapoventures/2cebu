@extends('admin.layout')
@section('title', 'Attractions')
@push('css')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<style>
   #map {
    height: 400px;
    width: 100%;
   }
   .table .form-group{
    margin-bottom:0;
   }
</style>
@endpush

@section('body')


<div class="row">
    <div class="col p-0">
        <div id="map" class="mb-3"></div>
    </div>
</div>

@php
    $linkDisabled = is_null($resourceData->id) ? 'disabled' : '';
@endphp
<ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="true">Details</a>
  </li>
  <li>
    <a class="nav-link {{ $linkDisabled }}" id="accomodations-tab" data-toggle="tab" href="#accomodations" role="tab" aria-controls="accomodations">Accomodations</a>
  </li>
  <li>
    <a class="nav-link {{ $linkDisabled }}" id="transpo-tab" data-toggle="tab" href="#transpo" role="tab" aria-controls="transpo" >Transportation</a>
  </li>
  <li>
    <a class="nav-link {{ $linkDisabled }}" id="activities-tab" data-toggle="tab" href="#activities" role="tab" aria-controls="activities">Activities</a>
  </li>
  <li>
    <a class="nav-link {{ $linkDisabled }}" id="delicacies-tab" data-toggle="tab" href="#delicacies" role="tab" aria-controls="delicacies">Delicacies</a>
  </li>
  <li>
    <a class="nav-link {{ $linkDisabled }}" id="photos-tab" data-toggle="tab" href="#photos" role="tab" aria-controls="photos">Photos</a>
  </li>
</ul>
<div class="tab-content mt-3" id="myTabContent">
  <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
    @if(is_null($resourceData->id))
    {!! Form::open(['url' => MyHelper::resource('store'), 'method' => 'POST', 'class' => 'ajax']) !!}
    @else
    {!! Form::model($resourceData, ['url' => MyHelper::resource('update', ['id' => $resourceData->id]), 'method' => 'PATCH', 'class' => 'ajax']) !!}
    @endif
        <div class="row">
            <div class="col-6">
                {!! Form::bsText('name', 'Name Of Place') !!}
                {!! Form::bsTextarea('description', 'Say something about this attraction', null, ['rows' => '3']) !!}
                {!! Form::bsTextarea('festivities', 'Festivities', null, ['rows' => '3']) !!}
                {!! Form::bsTextarea('policy', 'Policies', null, ['rows' => '3']) !!}
            </div>
            <div class="col-6">
                {!! Form::bsText('location', 'Location', null, ['id' => 'location']) !!}
                {!! Form::hidden('longitude') !!}
                {!! Form::hidden('latitude') !!}
                {!! Form::bsSelect('categories[]', 'Category', $categoryList, null, ['class' => 'custom-select category ', 'multiple' => true]) !!}
                @if($errors->has('categories'))
                    <small class="text-danger">{{ $errors->first('categories') }}</small>
                @endif
                {!! Form::bsSelect('tags[]', 'Tags', $tagList, is_null($resourceData->id) ? [] : $resourceData->tags->pluck('description'), ['class' => 'custom-select tags', 'multiple' => true]) !!}
                @if($errors->has('tags'))
                    <small class="bg-red text-white">{{ $errors->first('tags') }}</small>
                @endif
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::bsNumber('budget_range_min', 'Budget Range (Min)') !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::bsNumber('budget_range_max', 'Budget Range (Max)') !!}
                    </div>
                </div>
                @if($resourceData->isNotOwnedBy(Auth::id()))
                    <div class="row">
                        <div class="col-3">
                            {!! Form::bsSelect('attraction_status', 'Status', ['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'], null, ['class' => 'custom-select ']) !!}
                        </div>
                        <div class="col">
                            {!! Form::bsText('status_remarks', 'Status Remarks') !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-success">Save</button>
        {!! Form::close() !!}
    </div>
    <div class="tab-pane" id="accomodations" role="tabpanel" aria-labelledby="accomodations-tab">
        @if(!is_null($resourceData->id))
        {!! Form::open(['url' => route('admin.attraction.accomodation.update', ['attraction' => $resourceData->id]), 'method' => 'PATCH', 'class' => 'ajax']) !!}
        @endif
        <table class="table dynamic">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Minimum Rate</th>
                    <th>Max Rate</th>
                    <th>Remarks</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($resourceData->accomodations AS $accomodation)
                <tr>
                    <td>
                        {!! Form::bsText("item[{$loop->index}][description]", null, $accomodation->description, ['data-name' => 'item[idx][description]']) !!}
                        @if(!is_null($accomodation->id))
                            {!! Form::hidden("item[{$loop->index}][id]", $accomodation->id) !!}
                        @endif
                    </td>
                    <td>{!! Form::bsText("item[{$loop->index}][min_rate]", null, $accomodation->min_rate, ['data-name' => 'item[idx][min_rate]']) !!}</td>
                    <td>{!! Form::bsText("item[{$loop->index}][max_rate]", null, $accomodation->max_rate, ['data-name' => 'item[idx][max_rate]']) !!}</td>
                    <td>{!! Form::bsText("item[{$loop->index}][remarks]", null, $accomodation->remarks, ['data-name' => 'item[idx][remarks]']) !!}</td>
                    <td><a href="#" class="btn btn-danger remove-line"><i class="fas fa-times"></i></a></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td  colspan="6"><button type="button" class="btn btn-secondary add-line"><i class="fas fa-plus"></i> Add new line</button></td>
                </tr>
            </tfoot>
        </table>
        <hr>
        <button type="submit" class="btn btn-success">Save</button>
        {!! Form::close() !!}
    </div>
    <div class="tab-pane" id="transpo" role="tabpanel" aria-labelledby="transpo-tab">
        @if(!is_null($resourceData->id))
        {!! Form::open(['url' => route('admin.attraction.transportation.update', ['attraction' => $resourceData->id]), 'method' => 'PATCH', 'class' => 'ajax']) !!}
        @endif
        <table class="table dynamic">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Start Point</th>
                    <th>End Point</th>
                    <th>Cost</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($resourceData->transportations AS $transpo)
                <tr>
                    <td>
                        {!! Form::bsText("item[{$loop->index}][description]", null, $transpo->description, ['data-name' => 'item[idx][description]']) !!}
                        @if(!is_null($transpo->id))
                            {!! Form::hidden("item[{$loop->index}][id]", $transpo->id) !!}
                        @endif
                    </td>
                    <td>{!! Form::bsText("item[{$loop->index}][start_point]", null, $transpo->start_point, ['data-name' => 'item[idx][start_point]']) !!}</td>
                    <td>{!! Form::bsText("item[{$loop->index}][end_point]", null, $transpo->end_point, ['data-name' => 'item[idx][end_point]']) !!}</td>
                    <td>{!! Form::bsText("item[{$loop->index}][fare]", null, $transpo->fare, ['data-name' => 'item[idx][fare]']) !!}</td>
                    <td><a href="#" class="btn btn-danger remove-line"><i class="fas fa-times"></i></a></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5"><button type="button" class="btn btn-secondary add-line"><i class="fas fa-plus"></i> Add new line</button></td>
                </tr>
            </tfoot>
        </table>
        <hr>
        <button type="submit" class="btn btn-success">Save</button>
        {!! Form::close() !!}
    </div>
    <div class="tab-pane" id="activities" role="tabpanel" aria-labelledby="activities-tab">
        @if(!is_null($resourceData->id))
        {!! Form::open(['url' => route('admin.attraction.activity.update', ['attraction' => $resourceData->id]), 'method' => 'PATCH', 'class' => 'ajax']) !!}
        @endif
        <table class="table dynamic">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Cost</th>
                    <th>Remarks</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($resourceData->activities AS $activity)
                <tr>
                    <td>
                        {!! Form::bsText("item[{$loop->index}][description]", null, $activity->description, ['data-name' => 'item[idx][description]']) !!}
                        @if(!is_null($activity->id))
                            {!! Form::hidden("item[{$loop->index}][id]", $activity->id) !!}
                        @endif
                    </td>
                    <td>{!! Form::bsText("item[{$loop->index}][cost]", null, $activity->cost, ['data-name' => 'item[idx][cost]']) !!}</td>
                    <td>{!! Form::bsText("item[{$loop->index}][remarks]", null, $activity->remarks, ['data-name' => 'item[idx][remarks]']) !!}</td>
                    <td><a href="#" class="btn btn-danger remove-line"><i class="fas fa-times"></i></a></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5"><button type="button" class="btn btn-secondary add-line"><i class="fas fa-plus"></i> Add new line</button></td>
                </tr>
            </tfoot>
        </table>
        <hr>
        <button type="submit" class="btn btn-success">Save</button>
        {!! Form::close() !!}
    </div>
    <div class="tab-pane" id="delicacies" role="tabpanel" aria-labelledby="delicacies-tab">
        @if(!is_null($resourceData->id))
        {!! Form::open(['url' => route('admin.attraction.delicacy.update', ['attraction' => $resourceData->id]), 'method' => 'PATCH', 'class' => 'ajax']) !!}
        @endif
        <table class="table dynamic">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Cost</th>
                    <th>Remarks</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($resourceData->delicacies AS $delicacy)
                <tr>
                    <td>
                        {!! Form::bsText("item[{$loop->index}][description]", null, $delicacy->description, ['data-name' => 'item[idx][description]']) !!}
                        @if(!is_null($delicacy->id))
                            {!! Form::hidden("item[{$loop->index}][id]", $delicacy->id) !!}
                        @endif
                    </td>
                    <td>{!! Form::bsText("item[{$loop->index}][cost]", null, $delicacy->cost, ['data-name' => 'item[idx][cost]']) !!}</td>
                    <td>{!! Form::bsText("item[{$loop->index}][remarks]", null, $delicacy->remarks, ['data-name' => 'item[idx][remarks]']) !!}</td>
                    <td><a href="#" class="btn btn-danger remove-line"><i class="fas fa-times"></i></a></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5"><button type="button" class="btn btn-secondary add-line"><i class="fas fa-plus"></i> Add new line</button></td>
                </tr>
            </tfoot>
        </table>
        <hr>
        <button type="submit" class="btn btn-success">Save</button>
        {!! Form::close() !!}
    </div>
    <div class="tab-pane" id="photos" role="tabpanel" aria-labelledby="photos-tab">
        @if(!is_null($resourceData->id))
        {!! Form::open(['url' => route('admin.attraction.photo.update', ['attraction' => $resourceData->id]), 'method' => 'PATCH', 'class' => 'ajax']) !!}
        @endif
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> The first photo will be used as the attraction thumbnail.
            </div>
            <div class="row">
                @foreach($resourceData->photos AS $photo)
                <div class="col text-center">
                    <img src="{{ $photo->filepath }}" alt="..." class="img-thumbnail photo-upload-placeholder w-100" data-idx="{{ $loop->index }}">
                    {!! Form::file("photos[{$loop->index}][file]", ['id' => "photo-{$loop->index}", 'data-idx' =>  $loop->index, 'class' => 'd-none photo-input']) !!}
                    @if(!is_null($photo->id))
                        {!! Form::hidden("photos[{$loop->index}][id]", $photo->id, ['class' => 'photo-id', 'data-idx' => $loop->index]) !!}
                        <button class="btn btn-danger remove-photo mt-2 btn-sm" data-idx="{{ $loop->index }}"><i class="fas fa-times"></i> Remove</button>
                    @endif
                </div>
                @endforeach
            </div>
        <hr>
        <button type="submit" class="btn btn-success">Save</button>
        {!! Form::close() !!}
    </div>
</div>
@endsection

@push('js')
<script type="text/javascript" src="{{ asset('js/select2.full.min.js') }}"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {

        var defaultImage = "{{ MyHelper::photoPlaceholder() }}"
        //prelaod map location on edit

        $('.category').select2({
            placeholder: 'Select one or more category',
            allowClear:true

        });
        $('.tags').select2({
            tags:true,
            allowClear:true
        });

        $('.photo-upload-placeholder').click(function () {
            var $this = $(this);
            $('#photo-'+$this.data('idx')).trigger('click');
        });
        $('.photo-input').change(function () {
            var $this = $(this);
            $('img[data-idx='+$this.data('idx')+']').attr('src', window.URL.createObjectURL($this[0].files[0]))
            $('input[data-idx='+$this.data('idx')+'].photo-id').remove();
        })

        $('.remove-photo').click(function () {
            if(!confirm('Are you sure?')) return;
            var $this = $(this);

            $('input[data-idx='+$this.data('idx')+'].photo-id').remove();
            $('img[data-idx='+$this.data('idx')+']').attr('src', defaultImage)
            $this.remove();
        })
    });
</script>
<script>

    // determine if in edit mode and return lat,lng of existing attraction
    // otherwise the center of cebu
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
                zoom: 10,
                center: getDefaultMapCenter()
            }),
            marker = new google.maps.Marker({
                map: map,
                position: getDefaultMapCenter()
            });

        map.addListener('click', function (e) {
            geocoder.geocode({'location': e.latLng}, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        marker.setPosition(e.latLng);
                        $('#location').val(results[0].formatted_address)
                        $('[name=latitude]').val(e.latLng.lat())
                        $('[name=longitude]').val(e.latLng.lng())
                    }
                }
            })
        })
    }
</script>
 <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBb9gjcZGig7KAgoJC1EmMHA98Rp8Ayz98&callback=initMap">
    </script>
@endpush
