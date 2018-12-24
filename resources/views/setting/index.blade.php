@extends('layouts.app')

@section('content')

<div class="container">
    {!! Form::open() !!}
        <label> Select the bank accounts you wish to include in reporting </label>
        @foreach($bankAccounts as $bankAccount)
            <input type="checkbox" name="selected_bank_accounts[{{ $bankAccount->xero_id }}]">
        @endforeach
        {!! Form::submit('Save') !!}
    {!! Form::close() !!}
</div>

@endsection


