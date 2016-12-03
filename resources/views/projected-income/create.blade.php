@extends('layouts.app')

@section('content')

    <h2> Create Projected Income </h2>

    {!! Form::open(['url' => route('projected-income.store'), 'method' => 'post']) !!}
        <div class="form-group">
            {!! Form::label('date', 'Date') !!}
            {!! Form::date('date', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('amount', 'Amount') !!}
            <div class="input-group">
                <span class="input-group-addon">$</span>
                {!! Form::text('amount', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('revenue_account_xero_id', 'Revenue Account') !!}
            {!! Form::select(
                'revenue_account_xero_id',
                $revenueAccounts->pluck('name', 'xero_id'),
                null, [
                    'class' => 'form-control select2'
                ]
            ) !!}
        </div>
        <div class="form-group">
            {!! Form::label('bank_account_xero_id', 'Bank Account') !!}
            {!! Form::select(
                'bank_account_xero_id',
                $bankAccounts->pluck('name', 'xero_id'),
                null, [
                    'class' => 'form-control select2'
                ]
            ) !!}
        </div>
        <div class="form-group">
            {!! Form::label('tax_rate', 'Tax Rate') !!}
            {!! Form::select('tax_rate', ['GST on Income' => 'GST on Income'], 0, [
                'class' => 'form-control select2'
            ]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('reference', 'Reference') !!}
            {!! Form::text('reference', null, ['class' => 'form-control']) !!}
        </div>
    {!! Form::submit('Create Projected Invoice', ['class' => 'btn btn-default']) !!}
{!! Form::close() !!}

@endsection
