<?php

namespace App\Http\Controllers;

use App\Calculators\Calculator;
use App\Models\Account;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Calculator $calculator)
    {
        $this->middleware('auth');

        $this->calculator = $calculator;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bankAccounts = Account::selectedBankAccounts()->get();

        return view('home', [
            'bankAccounts' => $bankAccounts,
            'bankTotal'    => $bankAccounts->sum(
                function ($account) {
                    return (float) $account->balance();
                }
            ),
            'totalCash' => $this->calculator->getCashBalance()
        ]);
    }
}
