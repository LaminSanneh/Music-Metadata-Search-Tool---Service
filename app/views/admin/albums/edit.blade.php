@extends('admin.layouts.default')

@section('body')
<h3>Edit Album for Artist {{$artist->name}}</h3>
{{ Form::open(array('route' => array('admin.updateAlbum', $album->id))) }}
@include('admin.albums.editForm')
{{ Form::submit('Update', array('class' => 'btn btn-primary')) }}

{{Form::close()}}

@stop