@extends('layouts.app')

@section('content')

    <h2> Create Projection </h2>

    {!! Form::open(['url' => route('projected-journal.store'), 'method' => 'post']) !!}
        <div class="form-group">
            {!! Form::label('date', 'Date') !!}
            {!! Form::date('date', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('source_type', 'Type') !!}
            {!! Form::select('source_type', $sourceTypes, null, [
                'class' => 'form-control select2'
            ]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('amount', 'Amount') !!}
            <div class="input-group">
                <span class="input-group-addon">$</span>
                {!! Form::text('amount', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    {!! Form::label('to_account_id', 'From Account') !!}
                    {!! Form::select('to_account_id', $accounts, null, [
                        'class' => 'form-control select2'
                    ]) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    {!! Form::label('from_account_id', 'To Account') !!}
                    {!! Form::select('from_account_id', $accounts, null, [
                        'class' => 'form-control select2'
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('reference', 'Reference') !!}
            {!! Form::text('reference', null, ['class' => 'form-control']) !!}
        </div>
    {!! Form::submit('Create Projection', ['class' => 'btn btn-default']) !!}
{!! Form::close() !!}

@endsection
