@extends('layouts.blank')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"> Current Balances </div>

                <table class="table panel-body">
                    <tbody>
                        @foreach($bankAccounts as $bankAccount)
                            <tr>
                                <td> {{ $bankAccount->name }} </td>
                                <td> {{ $bankAccount->balance() }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr><td> Bank Total </td><td> {{ $bankTotal }} </td></tr>
                        <tr><td> Total Cash </td><td> {{ $totalCash }} </td></tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
