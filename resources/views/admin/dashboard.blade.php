@extends('admin.layout')
@section('title', 'Admin Dashboard')

@section('body')
<div class="row">
    <div class="col-sm-6">
        <table class="table">
            <thead>
                <tr class="bg-success text-white">
                    <th>Attraction</th>
                    <th>Pending Reviews Count</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($attractionPendingReviews as $attraction)
                    <tr>
                        <td>{{ $attraction->name }}</td>
                        <td>{{ $attraction->pending_reviews_count }}</td>
                        <td>
                            <a href="{{ route('admin.attraction.edit', ['id' => $attraction->id, 'status' => 'pending']) }}#reviews" class="btn btn-info">Manage Reviews</a>
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">No pending reviews</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
