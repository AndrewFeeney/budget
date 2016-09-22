@extends('layouts.app')

@section('content')

{!! Form::open(['url' => route('account.store'), 'method' => 'post']) !!}
    <div class="form-group">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('type', 'Type') !!}
        {!! Form::select('type', $types, null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('description', 'Description') !!}
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    </div>
    {!! Form::submit('Create', ['class' => 'btn btn-default']) !!}
{!! Form::close() !!}

@endsection
