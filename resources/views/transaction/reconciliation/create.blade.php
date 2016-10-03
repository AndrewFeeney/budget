@extends('layouts.app')

@section('content')

<h2> Reconcile Transaction </h2>

{!! Form::open(['url' => route('transaction.reconciliation.store', ['transaction' => $transaction]), 'method' => 'post']) !!}
    <h4>
        {{ $transaction->date }}
        {{ $transaction->account->name }}
        {{ $transaction->formatAmount() }}
        {{ $transaction->reference }}
    </h4>
    <div class="form-group">
        {!! Form::label('reconciled_transaction_id', 'Reconcile To') !!}
        {!! Form::select('reconciled_transaction_id', $candidates, null, ['class' => 'form-control']) !!}
    </div>
    {!! Form::submit('Reconcile', ['class' => 'btn btn-default']) !!}
{!! Form::close() !!}

@endsection
