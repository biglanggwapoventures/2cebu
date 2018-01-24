@extends('admin.layout')
@section('title', 'Users')
@section('body')
<table class="table table-striped">
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
