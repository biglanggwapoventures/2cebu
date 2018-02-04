@extends('admin.layout')
@section('title', 'Attractions')
@section('body')
<div class="row">
    <div class="col">
        {!! Form::open(['url' => url()->current(), 'method' => 'GET', 'class' => 'form-inline']) !!}
          <div class="form-group">
            <label for="inputPassword2">Name</label>
            {!! Form::text('name', null, ['class' => 'form-control ml-1', '']) !!}
          </div>
          <div class="form-group">
            <label for="inputPassword2" class="ml-1">Location</label>
            {!! Form::text('location', null, ['class' => 'form-control ml-1', '']) !!}
          </div>
          <div class="form-group">
            <label for="inputPassword2" class="ml-1">Category</label>
            {!! Form::select('category', $categories, null, ['class' => 'form-control ml-1', '']) !!}
          </div>
          <div class="form-group">
            <label for="inputPassword2" class="ml-1">Status</label>
            {!! Form::select('status', ['' => '** ALL **', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'], null, ['class' => 'form-control ml-1', '']) !!}
          </div>
          <button type="submit" class="btn btn-danger ml-2">Search</button>
        {!! Form::close() !!}
    </div>
</div>
<table class="table table-striped mt-2">
    <thead>
        <tr>
            <th class="bg-success text-white">Name</th>
            <th class="bg-success text-white">Location</th>
            <th class="bg-success text-white">Category</th>
            <th class="bg-success text-white">Submitted by<br>Submited on</th>
            <th class="bg-success text-white">Status</th>
            <th class="row-actions bg-success text-white"></th>
        </tr>
    </thead>
    <tbody>
        @forelse($resourceList as $row)
        <tr>
            <td>
                {{ $row->name }}<br>
                 @if($row->is_featured)
                    <span class="badge badge-info"><i class="fas fa-star"></i> Featured</span>
                @endif
            </td>
            <td>{{ $row->location }}</td>
            <td>{{ $row->categories->implode('description', ', ') }}</td>
            <td>{{ $row->owner->fullname }} <br> {{ date_create($row->created_at)->format('m/d/Y h:i A') }}</td>
            <td>
                @if($row->is('approved'))
                <div class="badge badge-success"><i class="fas fa-check"></i> Approved</div>
                @elseif($row->is('rejected'))
                <div class="badge badge-primary"><i class="fas fa-times"></i> Rejected</div>
                @else
                <div class="badge badge-secondary"><i class="fas fa-clock"></i> Pending</div>
                @endif
            </td>
            <td>
                @include('components.form.index-actions', ['id' => $row->id])
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-danger text-center">Emtpty table</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
