<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    const TYPES = [
        'Bank Account' => 'Bank Account',
        'Income Source' => 'Income Source',
        'Expense' => 'Expense',
    ];

    protected $fillable = [
        'name',
        'type',
        'description',
    ];

    /**
     * Returns the current account balance of the given account
     *
     * @return float
     **/
    public function balance()
    {
        return money_format('%(#10n', $this->transactions->sum( function($transaction) {
            return $transaction->amount;
        }));
    }

    /**
     * An account has many transactions
     **/
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
