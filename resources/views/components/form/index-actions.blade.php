<a href="{{ MyHelper::resource('edit', compact('id')) }}" class="btn btn-info btn-sm">
    <i class="fas fa-pencil-alt"></i> Edit
</a>

{!! Form::open(['url'=> MyHelper::resource('destroy', compact('id')), 'method'=> 'DELETE', 'style' => 'display:inline-block']) !!}
    <a class="btn btn-danger  btn-sm trash-row" href="#">
        <i class="fas fa-trash"></i> Delete
    </a>
{!! Form::close()!!}
