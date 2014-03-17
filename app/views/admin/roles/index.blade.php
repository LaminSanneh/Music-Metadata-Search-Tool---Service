@extends('admin.layouts.default')

@section('body')

<h2>Roles {{link_to_route('admin.roles.create','+ New Role', null,array('class' => 'btn btn-primary'))}}</h2>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tr>
            <th>Name</th>
            <th></th>
            <th></th>
        </tr>
        @foreach($roles as $role)
        <tr>
            <td>{{$role->name}}</td>
            <td>
                {{Form::open(array('route' => array('admin.roles.destroy', $role->id), 'method' => 'DELETE'))}}
                {{Form::submit('Delete', array('class' => 'btn btn-danger'))}}
                {{Form::close()}}
            </td>
            <td>
                {{ link_to_route('admin.roles.edit','Edit',array($role->id), array('class' => 'btn btn-primary')) }}
            </td>
        </tr>
        @endforeach
    </table>
</div>

@stop