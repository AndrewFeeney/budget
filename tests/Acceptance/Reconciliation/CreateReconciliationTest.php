<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateReconciliationTest extends TestCase
{
    use CreatesModels, DatabaseTransactions;

    /** @test */
    public function a_logged_in_user_can_reconcile_two_transactions_of_equal_and_opposite_value()
    {
        $this->createAndLoginUser();

        // Generate pair of balanced transactions
        $transactions = $this->createTransactionPair();

        // Visit create transaction page
        $this->visit(route('transaction.reconciliation.create', [
            'transaction' => $transactions['credit']
        ]))->seePageIs(route('transaction.reconciliation.create', [
            'transaction' => $transactions['credit']
        ]));

        // Select balancing transaction
        $this->select($transactions['debit']->id, 'reconciled_transaction_id')
            ->press('Reconcile');

        // Ensure we land on the correct page
        $this->seePageIs(route('transaction.index'));

        // Ensure the database records have been added
        $this->seeInDatabase('reconciliations', [
            'credit_id' => $transactions['credit']->id,
            'debit_id' => $transactions['debit']->id,
        ]);
    }
}
