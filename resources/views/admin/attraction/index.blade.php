@extends('admin.layout')
@section('title', 'Attractions')
@section('body')
<table class="table table-striped">
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
