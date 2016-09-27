@extends('layouts.app')

@section('content')

    <h2> Create Transaction </h2>

{!! Form::open(['url' => route('transaction.store'), 'method' => 'post']) !!}
    <div class="form-group">
        {!! Form::label('date', 'Date') !!}
        {!! Form::date('date', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('account_id', 'Account') !!}
        {!! Form::select('account_id', $accounts, null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('amount', 'Amount') !!}
        <div class="input-group">
            <span class="input-group-addon">$</span>
            {!! Form::text('amount', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    {!! Form::submit('Create', ['class' => 'btn btn-default']) !!}
{!! Form::close() !!}

@endsection
