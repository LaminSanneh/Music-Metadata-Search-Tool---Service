@extends('admin.layouts.default')

<h3>Edit Album for Artist {{$artist->name}}</h3>

@section('body')

{{ Form::open(array('route' => array('admin.updateAlbum', $album->id))) }}
@include('admin.albums.editForm')
{{ Form::submit('Update', array('class' => 'btn btn-primary')) }}

{{Form::close()}}

@stop