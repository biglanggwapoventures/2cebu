@extends('admin.layout')
@section('title', 'Users')
@section('body')
<table class="table table-striped">
    <thead class="thead-dark">
        <tr>
            <th>Full Name</th>
            <th>Gender</th>
            <th>Email</th>
            <th>Address</th>
            <th>Contact Number</th>
            <th></th>
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
