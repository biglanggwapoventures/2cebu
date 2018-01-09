@extends('admin.layout')
@section('title', 'Attraction Categories')
@section('body')
<div class="row">
    <div class="col-6">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Description</th>
                    <th></th>
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
