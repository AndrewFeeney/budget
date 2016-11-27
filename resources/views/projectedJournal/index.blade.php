@extends('layouts.app')

@section('content')

<div class="container">
    <a class="pull-right btn btn-default" href="{{ route('projected-journal.create') }}">
        <i class="glyphicon glyphicon-plus"></i> Create Projected Journal
    </a>
    <table class="table table-default">
        <thead>
            <tr>
                <th> Date </th>
                <th> From </th>
                <th> To </th>
                <th> Amount </th>
            </tr>
        </thead>
        <tbody>
            @foreach($projectedJournals as $projectedJournal)
                <tr>
                    <td> {{ $projectedJournal->date }} </td>
                    <td> {{ $projectedJournal->fromAccount() }} </td>
                    <td> {{ $projectedJournal->toAccount() }} </td>
                    <td> {{ $projectedJournal->amount }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
