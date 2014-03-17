@extends('admin.layouts.default')

@section('body')
<h2>Edit User</h2>
{{Form::open(array('route' => array('admin.users.update', $user->id), 'method' => 'PUT'))}}

@include('admin.users._form')

{{Form::submit('Update', array('class' => 'btn btn-success'))}}

{{Form::close()}}

@stop