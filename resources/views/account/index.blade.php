@extends('layouts.app')

@section('content')

<div class="container">
    <a href="{{ route('account.create') }}" class="btn btn-primary pull-right">
        <i class="glyphicon glyphicon-plus"></i> New Account
    </a>
    <table class="table table-hover">
        <thead> 
            <tr>
                <th> Name </th>
                <th> Type </th>
                <th> Balance </th>
            </tr>
        </thead>
        <tbody>
            @foreach($accounts as $account)
                <tr>
                    <td> {{ $account->name }} </td>
                    <td> {{ $account->type }} </td>
                    <td> {{ $account->balance() }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
