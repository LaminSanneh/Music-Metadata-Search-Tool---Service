@extends('admin.layouts.default')

@section('body')
<h2>Edit Role</h2>
{{Form::open(array('route' => array('admin.roles.update', $role->id), 'method' => 'PUT'))}}

@include('admin.roles._form')

{{Form::submit('Update', array('class' => 'btn btn-success'))}}

{{Form::close()}}

@stop