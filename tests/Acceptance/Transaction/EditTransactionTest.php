<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EditTransactionTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function a_logged_in_user_can_edit_an_unreconciled_transaction()
    {
        // Create user and login
        $user = $this->createUser();
        \Auth::login($user);

        // Create test data
        $transaction = $this->createTransaction();
        $newAccount = $this->createAccount();

        // Visit transaction edit page
        $this->visit(route('transaction.edit', ['transaction' => $transaction]));

        // Ensure current transaction data appears in fields
        $this->seeInField('date', $transaction->date)
            ->seeIsSelected('account_id', $transaction->account_id)
            ->seeInField('amount', $transaction->amount);

        // Enter updated transaction data and submit
        $this->type('2016-01-01', 'date')
            ->type($newAccount->id, 'account_id')
            ->type(123.45, 'amount')
            ->press('Update');

        // Ensure no errors are displayed
        $this->dontSee('alert-danger');

        // Ensure correct page is loaded
        $this->seePageIs(route('transaction.index'));

        // Ensure data is updated in database
        $this->seeInDatabase('transactions', [
            'date' => '2016-01-01',
            'account_id' => $newAccount->id,
            'amount' => 123.45,
        ]);
    }
}
