@extends('admin.layouts.default')

<h3>Edit Artist</h3>

@section('body')

{{ Form::open(array('route' => array('admin.updateArtist', $artist->id))) }}

@include('admin.artists.editForm')
    {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
{{Form::close()}}

@stop