@extends('layouts.default')

@section('body')
<h2>Login</h2>
{{ Form::model($user, array('route' => array('login'))) }}
<div class="form-group">
{{Form::label('email', 'Email') }}
{{Form::text('email', $user["email"], array('class' => 'form-control')) }}
</div>

<div class="form-group">
{{Form::label('password', 'Password') }}
{{Form::password('password',array('class' => 'form-control')) }}
</div>

{{ Form::submit('Login', array('class' => 'btn btn-primary')) }}

<p>
    {{link_to_route('register', 'Register',null)}}
</p>
{{Form::close()}}

@stop