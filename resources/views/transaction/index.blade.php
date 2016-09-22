@extends('layouts.app')

@section('content')

<div class="container">
    <a href="{{ route('transaction.create') }}" class="btn btn-primary pull-right">
        <i class="glyphicon glyphicon-plus"></i> New Transaction
    </a>
    <table class="table table-hover">
        <thead> 
            <tr>
                <th> Date </th>
                <th> Account </th>
                <th> Credit </th>
                <th> Debit </th>
                <th> Reference </th>
                <th> Reconciled </th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr class="@if($transaction->isReconciled()) success @endif")>
                    <td> {{ $transaction->date }} </td>
                    <td> {{ $transaction->account->name }} </td>
                    <td> {{ $transaction->getCredit() }} </td>
                    <td> {{ $transaction->getDebit() }} </td>
                    <td> {{ $transaction->reference }} </td>
                    <td> 
                        @if($transaction->isReconciled()) 
                            <i class="glyphicon glyphicon-ok-circle"></i>
                        @elseif($transaction->hasReconciliationCandidates())
                            <a
                                href="{{ route('transaction.reconciliation.create', [
                                'transaction' => $transaction
                                ]) }}"
                                class="btn btn-default"
                            >
                                <i class="glyphicon glyphicon-link"></i> Reconcile
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
