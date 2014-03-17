@extends('admin.layouts.default')

@section('body')

<h2>Users {{link_to_route('admin.users.create','+ New User', null,array('class' => 'btn btn-primary'))}}</h2>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th></th>
            <th></th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{link_to_route('admin.users.show',$user->first_name.' - '.$user->last_name,array($user->id))}}</td>
            <td>{{$user->email}}</td>
            <td>
                @foreach($user->roles as $role)
                    {{$role->name}},
                @endforeach
            </td>
            <td>
                {{Form::open(array('route' => array('admin.users.destroy', $user->id), 'method' => 'DELETE'))}}
                {{Form::submit('Delete', array('class' => 'btn btn-danger'))}}
                {{Form::close()}}
            </td>
            <td>
                {{ link_to_route('admin.users.edit','Edit',array($user->id), array('class' => 'btn btn-primary')) }}
            </td>
        </tr>
        @endforeach
    </table>
</div>

@stop