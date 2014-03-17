<div class="form-group">
    {{Form::label('name', 'Name')}}
    {{Form::text('name', $role->name, array('class' => 'form-control', 'placeholder' => 'Role Name'))}}
</div>