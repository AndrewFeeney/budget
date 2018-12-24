<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $guarded = [];

    public function amount()
    {
        // Get only the journal lines which involve a bank account
        $bankAccountJournalLines = $this->journalLines
            ->filter(
                function ($journalLine) {
                    return $journalLine->account_type == 'BANK' &&
                    $journalLine->account->currency_code == 'AUD';
                }
        );

        return $bankAccountJournalLines->sum(function ($journalLine) {
            return $journalLine->net_amount;
        });
    }

    /**
     *  A Journal belongs to an account
     **/
    public function account()
    {
        return $this->belongsTo(Account::class, 'source_xero_id', 'xero_id');
    }

    /**
     * Returns the currency code of the Journal's account
     **/
    public function accountCurrency()
    {
        $account = $this->account;

        if (is_null($account)) {
            return null;
        }

        return $account->currency_code;
    }

    /**
     * Returns this journal's journal lines which have a positive amount
     **/
    public function creditJournalLines()
    {
        return $this->journalLines()->where('gross_amount', '>', 0)->get();
    }

    /**
     * Returns true if this journal represents an accounts receivable payment
     * (i.e. a client's payment on an invoice)
     **/
    public function isAccountsReceivablePayment()
    {
        return $this->source_type == 'ACCRECPAYMENT';
    }

    /**
     * Returns true if this journal represents an internal bank transfer
     * @return bool
     **/
    public function isBankTransfer()
    {
        return $this->source_type == 'TRANSFER';
    }

    /**
     * Returns true if this journal represents funds paid out of the business
     * @return bool
     **/
    public function isCashPaid()
    {
        return $this->source_type == 'CASHPAID';
    }

    /**
     * Returns true if the Journal represents neutral cashflow in or out of the business
     * @return bool
     **/
    public function isCashflowNeutral()
    {
        return $this->isBankTransfer();
    }

    /**
     * Returns true if the journal represents funds coming in to the business
     * @return bool
     **/
    public function isCashflowPositive()
    {
        return $this->source_type == 'ACCREC';
    }

    /**
     * Returns true if the journal represents funds going out of the business
     * @return bool
     **/
    public function isCashflowNegative()
    {
        if ($this->isCashPaid()) {
            return true;
        }
    }

    /**
     * A Journal has many Journal Lines
     **/
    public function journalLines()
    {
        return $this->hasMany('App\Models\JournalLine');
    }

    /**
     * Return all Journals between the given start date and end date
     **/
    public function scopeBetweenDates($query, DateTime $startDate, DateTime $endDate)
    {
        return $query->where('date', '>', $startDate->format('Y-m-d h:m:s'))
            ->where('date', '<', $endDate->format('Y-m-d h:m:s'));
    }

    /**
     * Returns the summed total of all journal lines with positive net amounts
     **/
    public function totalReceived()
    {
        return $this->journalLines()
            ->where('net_amount', '>', 0)
            ->get()
            ->sum(function ($journalLine) {
                return $journalLine->net_amount;
            });
    }

    public function totalSpent()
    {
        return $this->journalLines()
            ->where('net_amount', '<', 0)
            ->get()
            ->sum(function ($journalLine) {
                return $journalLine->net_amount;
            });
    }
}
