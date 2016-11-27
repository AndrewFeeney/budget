<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    const TYPES = [
        'Bank Account' => 'Bank Account',
        'Income Source' => 'Income Source',
        'Expense' => 'Expense',
    ];

    protected $fillable = [
        'xero_id',
        'code',
        'name',
        'type',
        'bank_account_number',
        'status',
        'description',
        'bank_account_type',
        'currency_code',
        'tax_type',
        'is_system_account'
    ];

    /**
     * Returns the current account balance of the given account
     *
     * @return float
     **/
    public function balance()
    {
        return money_format('%(#10n', $this->journalLines->sum( function($transaction) {
            return $transaction->gross_amount;
        }));
    }

    /**
     * An account has many JournalLines
     **/
    public function journalLines()
    {
        return $this->hasMany('App\Models\JournalLine', 'account_xero_id', 'xero_id');
    }

    /**
     * An Account has many Journals
     **/
    public function journals()
    {
        return $this->hasMany('App\Models\Journal', 'source_id', 'xero_id');
    }

    /**
     * An account has many transactions
     **/
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
