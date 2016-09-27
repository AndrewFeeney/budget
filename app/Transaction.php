<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'date',
        'amount',
        'account_id'
    ];

    /**
     * A transaction belongs to an account
     **/
    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    /**
     * Returns the amount that would balance this transaction
     *
     * @return float
     **/
    public function balance()
    {
        return -$this->amount;
    }

    /**
     * Returns the money formatted credit amount or a hyphen if null
     *
     * @return string
     **/
    public function getCredit()
    {
        if ($this->isDebit()) {
            return '-';
        }
        return $this->formatAmount();
    }

    /**
     * Returns the money formatted debit amount or a hyphen if null
     *
     * @return string
     **/
    public function getDebit()
    {
        if ($this->isCredit()) {
            return '-';
        }
        return $this->formatAmount();
    }

    /**
     * Returns the money formatted amount of given type or a hyphen if null
     *
     * @return string
     **/
    public function formatAmount()
    { 
        // Return money formatted number
        return money_format('%(#10n', $this->amount);
    }

    /**
     * Returns true if transaction is a credit and not a debit
     *
     * @return bool
     **/
    public function isCredit()
    {
        return !$this->isDebit();
    }

    /**
     * Returns true if transaction is a debit and not a credit
     *
     * @return bool
     **/
    public function isDebit()
    {
        return $this->amount < 0;
    }

    /**
     * Returns true if the transaction has been fully reconciled to another transaction
     *
     * @return bool
     **/
    public function isReconciled()
    {
        return is_null($this->reconciliation) == false;
    }

    /**
     *  Returns the signed value of the transaction money formatted
     *
     *  @return string
     **/
    public function outputValue()
    {
        return money_format('%(#10n', $this->getValue());
    }

    /**
     * A Transaction has one reconciliation
     **/
    public function reconciliation()
    {
        if ($this->isCredit()) {
            return $this->hasOne('App\Reconciliation', 'credit_id', 'id');
        }
        return $this->hasOne('App\Reconciliation', 'debit_id');
    }

    /**
     * Returns the transactions which could be reconciled against this one
     *
     * @return Illuminate\Support\Collection
     **/
    public function reconciliationCandidates()
    {
        return self::where('amount', -$this->amount)
            ->get()
            ->filter( function($transaction) {
                return !$transaction->isReconciled();
            });
    }

    /**
     * Returns the transactions which could be reconciled against this one
     *
     * @return Illuminate\Support\Collection
     **/
    public function hasReconciliationCandidates()
    {
        return ($this->reconciliationCandidates()->count() > 0);
    }
}
