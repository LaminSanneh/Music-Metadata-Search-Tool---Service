<div class="form-group">
    {{Form::label('first_name', 'First Name')}}
    {{Form::text('first_name', $user->first_name, array('class' => 'form-control', 'placeholder' => 'First Name'))}}
</div>

<div class="form-group">
    {{Form::label('last_name', 'LastName')}}
    {{Form::text('last_name', $user->last_name, array('class' => 'form-control', 'placeholder' => 'Last Name'))}}
</div>

<div class="form-group">
    {{Form::label('email', 'Email')}}
    {{Form::text('email', $user->email,
    array('class' => 'form-control', 'placeholder' => 'Email'))}}
</div>

<div class="form-group">
    {{Form::label('confirmed', 'Email Confirmed')}}
    {{Form::checkbox('confirmed', $user->confirmed, $user->confirmed)}}
</div>