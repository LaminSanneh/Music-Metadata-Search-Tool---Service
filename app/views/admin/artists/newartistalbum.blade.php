@extends('admin.layouts.default')

@section('body')
<h3>New Album For Artist {{$artist->name}}</h3>
{{ Form::open(array('route' => array('admin.saveNewArtistAlbum', $artist->id))) }}
@include('admin.albums.editForm')
{{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
{{Form::close()}}

@stop