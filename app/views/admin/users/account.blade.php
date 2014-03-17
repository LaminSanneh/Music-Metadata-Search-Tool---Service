@extends('layouts.default')

@section('body')

<h2>Account Status</h2>
@if(Auth::user()->confirmed)
<p class="label label-success">Activated</p>

<h2>Your Api Keys</h2>
<table class="table table-striped table-bordered">
    <tr>
        <th>Key</th>
        <th>Domain</th>
        <th>Status</th>
        <th></th>
    </tr>
    @foreach($apiKeys as $apiKey)
    <tr>
        <td>{{$apiKey->key}}</td>
        <td>{{$apiKey->domain}}</td>
        <td>{{($apiKey->is_active) ? "<span class='label label-success'>active</span>": "<span class='label label-danger'>inactive(waiting approval)</span>" }}</td>
        <td>{{link_to_route('deleteApiKey','Delete',array($apiKey->id))}}</td>
    </tr>
    @endforeach
</table>

{{Form::open(array('route' => 'requestNewApiKey'))}}
<h3>Create new Api key</h3>
<div class="form-group">
    {{ Form::label('domain', 'Domain') }}
    {{ Form::text('domain', null, array('class' => 'form-control')) }}
</div>
{{Form::submit('Create')}}
{{Form::close()}}
@else
<p class="label label-danger">InActive</p>
    {{link_to_route('resendEmailConfirm','Resend Confirm Code',null, array('class' => 'btn btn-primary'))}}

    <div>
        <h2>Confirm Email Code</h2>
        <p>Paste here the code you received through email. If you did not receive an email, use the resend button to get another activation code.</p>
        {{Form::open(array('route' => array('activateUserAccount')))}}

            <div class="form-group">
                {{Form::label('activation_code', 'Code')}}
                {{Form::text('activation_code', null, array('class' => 'form-control', 'placeholder' => 'Paste Code here'))}}
            </div>

            {{Form::submit('Activate', array('class' => 'btn btn-success'))}}

        {{Form::close()}}
    </div>
@endif

@stop