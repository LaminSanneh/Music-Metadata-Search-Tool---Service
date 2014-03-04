@extends('admin.layouts.default')

@section('body')
<h3>New Song For Album{{$album->name}}</h3>
{{ Form::open(array('route' => array('admin.saveNewAlbumSong', $album->id))) }}
@include('admin.songs.editForm')
{{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
{{Form::close()}}

@stop