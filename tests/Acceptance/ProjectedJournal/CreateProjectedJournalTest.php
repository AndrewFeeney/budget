<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\ProjectedJournal;

class CreateProjectedJournalTest extends TestCase
{
    use CreatesModels;
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_create_a_projected_invoice_journal()
    {
        // Create user and sign in
        $user = $this->getTestObject('user');
        Auth::login($user);

        // Create accounts
        $accountsReceivable = $this->getAccountsReceivableAccount();
        $salesAccount = $this->getSalesAccount();
        $gstAccount = $this->gstAccount();
        $bankAccount = $this->getBankAccount();

        // Visit projections create page
        $this->visit(route('projected-income.create'));

        // Fill out form
        $this->type('2017-01-01 09:00:00', 'date')
            ->select('Invoice', 'type')
            ->select('GST on Income', 'tax_rate')
            ->type('100.00', 'amount')
            ->type('Invoice', 'reference')
            ->press('Create Projected Invoice');

        // See that we are redirected to expected page
        $this->seePageIs(route('projected-journal.index'));

        // See the expected resulta in the database
        $this->seeInDatabase('projected_journals', [
            'date' => '2017-01-01 09:00:00',
            'source_type' => 'ACCREC',
            'reference' => 'Invoice'
        ]);
        $this->seeInDatabase('projected_journals', [
            'date' => '2017-01-01 09:00:00',
            'source_type' => 'ACCRECPAYMENT',
        ]);

        // Get newly created projected journals from database
        $accountsReceivableInvoice = ProjectedJournal::where('source_type', 'ACCREC')->first();
        $accountsReceivablePayment = ProjectedJournal::where('source_type', 'ACCRECPAYMENT')->first();

        // Assert that projected journal lines have been created for the accounts
        // receivable invoice projected journal
        $this->seeInDatabase('projected_journal_lines', [
            'projected_journal_id' => $accountsReceivableInvoice->id,
            'account_xero_id' => $accountsReceivable->xero_id,
            'net_amount' => 110.00,
            'gross_amount' => 110.00,
            'tax_amount' => 0,
            'tax_type' => null,
            'account_type' => 'CURRENT',
        ]);
        $this->seeInDatabase('projected_journal_lines', [
            'projected_journal_id' => $accountsReceivableInvoice->id,
            'account_xero_id' => $salesReceivable->xero_id,
            'net_amount' => -100.00,
            'gross_amount' => -110.00,
            'tax_amount' => -10.00,
            'tax_type' => 'OUTPUT',
            'account_type' => 'REVENUE',
        ]);
        $this->seeInDatabase('projected_journal_lines', [
            'projected_journal_id' => $accountsReceivableInvoice->id,
            'account_xero_id' => $gstAccount->xero_id,
            'net_amount' => -10.00,
            'gross_amount' => -10.00,
            'tax_amount' => 0.00,
            'tax_type' => 'OUTPUT',
            'account_type' => 'CURRLIAB',
        ]);

        // Assert that projected journal lines have been created for the accounts
        // receivable payment projected journal
        $this->seeInDatabase('projected_journal_lines', [
            'projected_journal_id' => $accountsReceivablePayment->id,
            'account_xero_id' => $accountsReceivable->xero_id,
            'net_amount' => -110.00,
            'gross_amount' => -110.00,
            'tax_amount' => 0,
            'tax_type' => null,
            'account_type' => 'CURRENT',
        ]);
        $this->seeInDatabase('projected_journal_lines', [
            'projected_journal_id' => $accountsReceivablePayment->id,
            'account_xero_id' => $bankAccount->xero_id,
            'net_amount' => 110.00,
            'gross_amount' => 110.00,
            'tax_amount' => 0,
            'tax_type' => null,
            'account_type' => 'BANK',
        ]);
    }
}
