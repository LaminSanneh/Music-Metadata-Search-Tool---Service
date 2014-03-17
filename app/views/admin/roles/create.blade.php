@extends('admin.layouts.default')

@section('body')
<h2>Create Role</h2>
{{Form::open(array('route' => array('admin.roles.store')))}}

@include('admin.roles._form')

{{Form::submit('Create', array('class' => 'btn btn-success'))}}

{{Form::close()}}

@stop