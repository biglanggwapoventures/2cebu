<a href="{{ MyHelper::resource('edit', compact('id')) }}" class="btn btn-info btn-sm btn-block mb-1">
    <i class="fas fa-pencil-alt"></i> Edit
</a>

{!! Form::open(['url'=> MyHelper::resource('destroy', compact('id')), 'method'=> 'DELETE']) !!}
    <a class="btn btn-primary btn-block btn-sm trash-row" href="#">
        <i class="fas fa-trash"></i> Delete
    </a>
{!! Form::close()!!}
