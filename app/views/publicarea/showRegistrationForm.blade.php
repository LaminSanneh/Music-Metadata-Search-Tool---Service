@extends('layouts.default')

@section('body')
<h2>Register</h2>
{{ Form::model($user, array('route' => array('register'))) }}
<ul>
    @foreach ($errors->all() as $message)
    <li>{{$message}}</li>
    @endforeach
</ul>
<div class="form-group">
    {{Form::label('email', 'Email') }}
    {{Form::text('email', $user["email"], array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{Form::label('password', 'Password') }}
    {{Form::password('password',array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{Form::label('password_confirmation', 'Password Confirm') }}
    {{Form::password('password_confirmation',array('class' => 'form-control')) }}
</div>

{{ Form::submit('Register', array('class' => 'btn btn-primary')) }}
{{Form::close()}}

@stop