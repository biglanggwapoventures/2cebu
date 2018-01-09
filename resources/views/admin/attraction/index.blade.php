@extends('admin.layout')
@section('title', 'Attractions')
@section('body')
<table class="table table-striped">
    <thead class="thead-dark">
        <tr>
            <th>Name</th>
            <th>Location</th>
            <th>Category</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($resourceList as $row)
        <tr>
            <td>{{ $row->name }}</td>
            <td>{{ $row->location }}</td>
            <td>{{ $row->categories->implode('description', ', ') }}</td>
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
