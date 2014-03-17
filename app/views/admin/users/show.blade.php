@extends('admin.layouts.default')

@section('body')

<h2>Users {{link_to_route('admin.users.create','+ New User', null,array('class' => 'btn btn-primary'))}}</h2>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <td>{{$user->first_name}} - {{$user->last_name}}</td>
            <td>{{$user->email}}</td>
            <td>
                {{Form::open(array('route' => array('admin.users.destroy', $user->id), 'method' => 'DELETE'))}}
                {{Form::submit('Delete', array('class' => 'btn btn-danger'))}}
                {{Form::close()}}
            </td>
            <td>
                {{ link_to_route('admin.users.edit','Edit',array($user->id), array('class' => 'btn btn-primary')) }}
            </td>
        </tr>
    </table>
</div>


<h2>Roles In</h2>
<table class="table table-striped table-bordered">
    <tr>
        <th>Name</th>
        <th></th>
    </tr>
    @foreach($roles as $role)
    <tr>
        <td>{{$role->name}}</td>
        <td>
            {{ link_to_route('admin.users.removeFromRole','-Remove From Role',array($user->id, $role->id), array('class' => 'btn btn-danger')) }}
        </td>
    </tr>
    @endforeach
</table>

<h2>Roles Not In</h2>
<table class="table table-striped table-bordered">
    <tr>
        <th>Name</th>
        <th></th>
    </tr>
    @foreach($other_roles as $role)
    <tr>
        <td>{{$role->name}}</td>
        <td>
            {{ link_to_route('admin.users.addToRole','+Add To Role',array($user->id, $role->id), array('class' => 'btn btn-danger')) }}
        </td>
    </tr>
    @endforeach
</table>

<h2>User Api Keys</h2>
<table class="table table-striped table-bordered">
    <tr>
        <th>Key</th>
        <th>Domain</th>
        <th>Status</th>
        <th></th>
        <th></th>
    </tr>
    @foreach($apiKeys as $apiKey)
    <tr>
        <td>{{$apiKey->key}}</td>
        <td>{{$apiKey->domain}}</td>
        <td>{{($apiKey->is_active) ? "<span class='label label-success'>active</span>": "<span class='label label-danger'>inactive(waiting approval)</span>" }}</td>
        <td>{{link_to_route('deleteApiKey','Delete',array($apiKey->id))}}</td>
        <td>
            @if($apiKey->is_active)
            {{ link_to_route('deActivateApiKey','Deactive key',array($apiKey->id), array('class' => 'btn btn-danger')) }}
            @else
            {{ link_to_route('activateApiKey','Activate key',array($apiKey->id), array('class' => 'btn btn-danger')) }}
            @endif
        </td>
    </tr>
    @endforeach
</table>

@stop