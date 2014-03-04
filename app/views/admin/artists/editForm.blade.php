<div class="form-group">
    {{ Form::label('name', 'Artist Name') }}
    {{ Form::text('name', $artist->name, array('class' => 'form-control')) }}
</div>
<div class="form-group">
    {{ Form::label('real_name', 'Real Name') }}
    {{ Form::text('real_name', $artist->real_name, array('class' => 'form-control')) }}
</div>
<div class="form-group">
    {{ Form::label('profile', 'Profile') }}
    {{ Form::text('profile', $artist->profile, array('class' => 'form-control')) }}
</div>