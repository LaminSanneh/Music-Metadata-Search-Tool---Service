@extends('admin.layouts.default')

<h3>Edit Song For Album{{$album->name}}</h3>

@section('body')

{{ Form::open(array('route' => array('admin.updateSong', $song->id))) }}
@include('admin.songs.editForm')
{{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
{{Form::close()}}

@stop