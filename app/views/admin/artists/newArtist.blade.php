@extends('admin.layouts.default')

<h3>New Artist</h3>

@section('body')

{{ Form::open(array('route' => array('admin.saveNewArtist'))) }}
@include('admin.artists.editForm')
{{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
{{Form::close()}}

@stop