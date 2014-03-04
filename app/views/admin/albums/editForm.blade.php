<div class="form-group">
    {{ Form::label('name', 'Album Name') }}
    {{ Form::text('name', $album->name, array('class' => 'form-control')) }}
</div>
<div class="form-group">
    {{ Form::label('genre', 'Genre') }}
    {{ Form::text('genre', $album->genre, array('class' => 'form-control')) }}
</div>
<div class="form-group">
    {{ Form::label('notes', 'Notes') }}
    {{ Form::textarea('notes', $album->notes, array('class' => 'form-control')) }}
</div>
<div class="form-group">
    {{ Form::label('picture', 'Picture') }}
    {{ Form::text('picture', $album->picture, array('class' => 'form-control')) }}
</div>