<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const TYPES = [
        'Credit' => 'Credit',
        'Debit' => 'Debit'
    ];

    protected $fillable = [
        'date',
        'credit',
        'debit',
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
     * Returns the money formatted credit amount or a hyphen if null
     *
     * @return string
     **/
    public function getCredit()
    {
        return $this->getAmount('credit');
    }

    /**
     * Returns the money formatted debit amount or a hyphen if null
     *
     * @return string
     **/
    public function getDebit()
    {
        return $this->getAmount('debit');
    }

    /**
     * Returns the money formatted amount of given type or a hyphen if null
     *
     * @return string
     **/
    public function getAmount($type)
    {
        // If the amount of that type is null, return hyphen
        if (is_null($this->$type)) {
            return '-';
        }
        
        // Return money formatted number
        return money_format('%(#10n', $this->$type);
    }

    /**
     * Returns the monetary value of the transaction as signed float
     *
     * @return float
     **/
    public function getValue()
    {
        if ($this->isDebit()) {
            return (float) -$this->debit;
        }
        return (float) $this->credit;
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
        return is_null($this->credit);
    }

    /**
     * Returns true if the transaction has been fully reconciled to another transaction
     *
     * @return bool
     **/
    public function isReconciled()
    {
        return !is_null($this->reconciliation);
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
        return $this->hasOne('App\Reconciliation', 'debit_id', 'id');
    }

    /**
     * Returns the transactions which could be reconciled against this one
     *
     * @return Illuminate\Support\Collection
     **/
    public function reconciliationCandidates()
    {
        if ($this->isDebit()) {
            return self::where('credit', $this->debit)
                ->get()
                ->filter( function($transaction) {
                    return !$transaction->isReconciled();
                });
        }

        return self::where('debit', $this->credit)
            ->get()
            ->filter( function($transaction) {
                return $transaction->isReconciled() == false;
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
