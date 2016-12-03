@extends('layouts.app')

@section('content')

<div class="container">
    <a href="{{ route('projected-income.create') }}" class="btn btn-primary pull-right">
        <i class="glyphicon glyphicon-plus"></i> Add Projected Income
    </a>
    <table class="table table-hover">
        <thead>
            <tr>
                <th> Date </th>
                <th> Type </th>
                <th> Amount </th>
                <th> Reference </th>
            </tr>
        </thead>
        <tbody>
            @foreach($projectedJournals as $projectedJournal)
                <tr>
                    <td> {{ $projectedJournal->date }} </td>
                    <td> {{ $projectedJournal->type() }} </td>
                    <td> {{ $projectedJournal->amount() }} </td>
                    <td> {{ $projectedJournal->reference }} </td>
                        <div class="dropdown pull-right">
                            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-option-vertical"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li>
                                    <a href="{{ route('projected-journal.edit', compact('projectedJournal')) }}">
                                        <i class="glyphicon glyphicon-edit"></i>
                                        Edit
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

