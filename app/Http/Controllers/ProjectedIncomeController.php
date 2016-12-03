<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\ProjectedJournal;
use App\Models\ProjectedJournalLine;
use App\Models\Account;
use App\Repositories\Accounts;

class ProjectedIncomeController extends Controller
{
    private $accounts;

    public function __construct(Accounts $accounts)
    {
        $this->accounts = $accounts;
    }

    /**
     * Shows the form to create a projected journal
     **/
    public function create()
    {
        // Get revenue accounts
        $revenueAccounts = Account::where('type', 'REVENUE')
            ->orderBy('code', 'asc')
            ->get()
            ->map(function ($account) {
                return [
                    'xero_id' => $account->xero_id,
                    'name' => $account->code . ' ' . $account->name
                ];
            });

        // Get bank accounts
        $bankAccounts = Account::where('type', 'BANK')
            ->orderBy('code', 'asc')
            ->get()
            ->map(function ($account) {
                return [
                    'xero_id' => $account->xero_id,
                    'name' => $account->code . ' ' . $account->name
                ];
            });

        // Get source types
        $sourceTypes = collect(ProjectedJournal::SOURCE_TYPES);

        return view('projected-income.create', compact([
            'bankAccounts',
            'revenueAccounts',
            'sourceTypes'
        ]));
    }

    /**
     * Saves the new projected journal to the database
     **/
    public function store(Request $request)
    {
        // Create the projected journals
        $accountsReceivableInvoiceJournal = ProjectedJournal::create(
            $request->only(['date', 'reference']) + [
                'source_type' => 'ACCREC'
            ]
        );
        $accountsReceivablePaymentJournal = ProjectedJournal::create(
            $request->only(['date', 'reference']) + [
                'source_type' => 'ACCRECPAYMENT'
            ]
        );

        $grossAmount = $request->amount * (is_null($request->tax_type) ? 1.1 : 1.0);

        // Create the projected journal lines
        ProjectedJournalLine::create([
            'projected_journal_id' => $accountsReceivableInvoiceJournal->id,
            'account_xero_id' => $this->accounts->getSystemAccount('Accounts Receivable')->xero_id,
            'net_amount' => $grossAmount,
            'gross_amount' => $grossAmount,
            'tax_amount' => 0,
            'tax_type' => null,
            'account_type' => 'CURRENT'
        ]);
        ProjectedJournalLine::create([
            'projected_journal_id' => $accountsReceivableInvoiceJournal->id,
            'account_xero_id' => $request->revenue_account_xero_id,
            'net_amount' => -$request->amount,
            'gross_amount' => -$grossAmount,
            'tax_amount' => $request->amount - $grossAmount,
            'tax_type' => 'OUTPUT',
            'account_type' => 'REVENUE',
        ]);
        ProjectedJournalLine::create([
            'projected_journal_id' => $accountsReceivableInvoiceJournal->id,
            'account_xero_id' => $this->accounts->getSystemAccount('GST')->xero_id,
            'net_amount' => $request->amount - $grossAmount,
            'gross_amount' => $request->amount - $grossAmount,
            'tax_amount' => 0,
            'tax_type' => 'OUTPUT',
            'account_type' => 'CURRLIAB',
        ]);

        // Create accounts receivable payment journals
        ProjectedJournalLine::create([
            'projected_journal_id' => $accountsReceivablePaymentJournal->id,
            'account_xero_id' => $this->accounts->getSystemAccount('Accounts Receivable')->xero_id,
            'net_amount' => -$grossAmount,
            'gross_amount' => -$grossAmount,
            'tax_amount' => 0,
            'tax_type' => null,
            'account_type' => 'CURRENT'
        ]);
        ProjectedJournalLine::create([
            'projected_journal_id' => $accountsReceivablePaymentJournal->id,
            'account_xero_id' => $request->bank_account_xero_id,
            'net_amount' => $grossAmount,
            'gross_amount' => $grossAmount,
            'tax_amount' => 0,
            'tax_type' => null,
            'account_type' => 'BANK'
        ]);
    }
}
