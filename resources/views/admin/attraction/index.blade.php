@extends('admin.layout')
@section('title', 'Attractions')
@section('body')
<table class="table table-striped">
    <thead class="thead-dark">
        <tr>
            <th>Name</th>
            <th>Location</th>
            <th>Category</th>
            <th>Submitted by<br>Submited on</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($resourceList as $row)
        <tr>
            <td>{{ $row->name }}</td>
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
