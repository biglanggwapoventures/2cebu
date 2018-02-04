@extends('admin.layout')
@section('title', 'Users')
@section('body')
{!! Form::open(['url' => url()->current(), 'method' => 'GET', 'class' => 'form-inline mb-2 mt-2']) !!}
<div class="form-group">
  <div class="form-group">
    <label for="inputPassword2" class="ml-1">Name</label>
    {!! Form::text('name', null, ['class' => 'form-control ml-1', '']) !!}
  </div>
  <div class="form-group">
    <label for="inputPassword2" class="ml-1">Email</label>
    {!! Form::text('email', null, ['class' => 'form-control ml-1', '']) !!}
  </div>
  <button type="submit" class="btn btn-danger ml-2">Search</button>
{!! Form::close() !!}
<table class="table table-striped mt-2">
    <thead>
        <tr>
            <th class="bg-success text-white">Full Name</th>
            <th class="bg-success text-white">Gender</th>
            <th class="bg-success text-white">Email</th>
            <th class="bg-success text-white">Address</th>
            <th class="bg-success text-white">Contact Number</th>
            <th  class="row-actions bg-success text-white"></th>
        </tr>
    </thead>
    <tbody>
        @forelse($resourceList as $row)
        <tr>
            <td>{{ $row->fullname }}</td>
            <td>{{ $row->gender }}</td>
            <td>{{ $row->email}} <br> <small>Using: <span class="text-info">{{ $row->registration_method }}</span></small></td>
            <td>{{ $row->address }}</td>
            <td>{{ $row->contact_number }}</td>
            <td>
                @include('components.form.index-actions', ['id' => $row->id])
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-danger text-center">Emtpty table</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
