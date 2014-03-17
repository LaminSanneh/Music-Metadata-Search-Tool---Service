@extends('admin.layouts.default')

@section('body')
<h2>Create User</h2>
{{Form::open(array('route' => array('admin.users.store')))}}

@include('admin.users._form')

{{Form::submit('Create', array('class' => 'btn btn-success'))}}

{{Form::close()}}

@stop