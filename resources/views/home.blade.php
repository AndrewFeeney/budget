@extends('layouts.app')

@section('content')

    <div class="container mx-auto">
        <div class="max-w-md mx-auto">

            <h1> Current Balances </h1>

            <table class="mt-4 w-full text-lg">
                <tbody>
                    @foreach($bankAccounts as $bankAccount)
                        <tr>
                            <td class=""> {{ $bankAccount->name }} </td>
                            <td class="text-right font-mono"> {{ $bankAccount->balance() }} </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class=""><td> Bank Total </td><td  class="text-right font-mono"> {{ $bankTotal }} </td></tr>
                    <tr class=""><td> Total Cash </td><td  class="text-right font-mono"> {{ $totalCash }} </td></tr>
                </tfoot>
            </table>
        </div>
    </div>

@endsection
