@extends('layouts.app')

@section('content')

    <h2> Edit Transaction </h2>

    {!! Form::open([
        'url' => route('transaction.update', ['transaction' => $transaction]),
        'method' => 'patch'
    ]) !!}
    <div class="form-group">
        {!! Form::label('date', 'Date') !!}
        {!! Form::date('date', $transaction->date, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('account_id', 'Account') !!}
        {!! Form::select('account_id', $accounts, $transaction->account_id, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('amount', 'Amount') !!}
        <div class="input-group">
            <span class="input-group-addon">$</span>
            {!! Form::text('amount', $transaction->amount, ['class' => 'form-control']) !!}
        </div>
    </div>
    {!! Form::submit('Update', ['class' => 'btn btn-default']) !!}
{!! Form::close() !!}

@endsection
