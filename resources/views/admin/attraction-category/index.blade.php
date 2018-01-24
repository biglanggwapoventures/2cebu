@extends('admin.layout')
@section('title', 'Attraction Categories')
@section('body')
<div class="row">
    <div class="col-6">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="bg-success text-white">Description</th>
                    <th class="row-actions bg-success text-white"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($resourceList as $row)
                <tr>
                    <td>{{ $row->description }}</td>
                    <td>
                        @include('components.form.index-actions', ['id' => $row->id])
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-danger text-center">Emtpty table</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
