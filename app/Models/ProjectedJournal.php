<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectedJournal extends Model
{
    const SOURCE_TYPES = [
        'ACCREC' => 'Accounts Receivable Invoice',
        'ACCPAY' => 'Accounts Payable Invoice',
        'ACCRECCREDIT' => 'Accounts Receivable Credit Note',
        'ACCPAYCREDIT' => 'Accounts Payable Credit Note',
        'ACCRECPAYMENT' => 'Payment on an Accounts Receivable Invoice',
        'ACCPAYPAYMENT' => 'Payment on an Accounts Payable Invoice',
        'ARCREDITPAYMENT' => 'Accounts Receivable Credit Note Payment',
        'APCREDITPAYMENT' => 'Accounts Payable Credit Note Payment',
        'CASHREC' => 'Receive Money Bank Transaction',
        'CASHPAID' => 'Spend Money Bank Transaction',
        'TRANSFER' => 'Bank Transfer',
        'ARPREPAYMENT' => 'Accounts Receivable Prepayment',
        'APPREPAYMENT' => 'Accounts Payable Prepayment',
        'AROVERPAYMENT' => 'Accounts Receivable Overpayment',
        'APOVERPAYMENT' => 'Accounts Payable Overpayment',
        'EXPCLAIM' => 'Expense Claim',
        'EXPPAYMENT' => 'Expense Claim Payment',
        'MANJOURNAL' => 'Manual Journal',
        'PAYSLIP' => 'Payslip',
        'WAGEPAYABLE' => 'Payroll Payable',
        'INTEGRATEDPAYROLLPE' => 'Payroll Expense',
        'INTEGRATEDPAYROLLPT' => 'Payroll Payment',
        'EXTERNALSPENDMONEY' => 'Payroll Employee Payment',
        'INTEGRATEDPAYROLLPTPAYMENT' => 'Payroll Tax Payment',
        'INTEGRATEDPAYROLLCN' => 'Payroll Credit Note'
    ];

    protected $guarded = [];

    /**
     * Returns the Account which is the origin of the projected journal
     *
     * @return App\Models\Account
     **/
    public function fromAccount()
    {
        return $this->projectedJournalLines()
            ->where('amount', '<', 0)
            ->first();
    }

    /**
     * A Projected Journal has many Projected Journal Lines
     **/
    public function projectedJournalLines()
    {
        return $this->hasMany(ProjectedJournalLine::class);
    }

    /**
     * Returns the Account which is the destination of the projected journal
     *
     * @return App\Models\Account
     **/
    public function toAccount()
    {
        return $this->projectedJournalLines()
            ->where('amount', '>', 0)
            ->first();
    }
}

