<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateTransactionTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function a_logged_in_user_can_create_a_transaction()
    {
        $user = $this->createUser();

        $account = $this->createAccount();

        auth()->login($user);

        $this->visit(route('transaction.create'))
            ->seePageIs(route('transaction.create'));

        $this->type('2016-01-01', 'date')
            ->select($account->id, 'account_id')
            ->type('1234.56', 'amount')
            ->press('Create');
        
        $this->seePageIs(route('transaction.index'));

        $this->seeInDatabase('transactions', [
            'date' => '2016-01-01',
            'amount' => 1234.56,
            'account_id' => $account->id,
        ]);
    }
}
