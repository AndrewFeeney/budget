<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TransactionTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function is_credit_method_returns_true_when_transaction_amount_is_positive()
    {
        $transaction = $this->createTransaction(['amount' => 1]);
        
        $this->assertTrue($transaction->isCredit());
    }
    
    /** @test */
    public function is_credit_method_returns_false_when_transaction_amount_is_negative()
    {
        $transaction = $this->createTransaction(['amount' => -1]);
        
        $this->assertFalse($transaction->isCredit());
    }
    
    /** @test */
    public function is_debit_method_returns_true_when_transaction_amount_is_negative()
    {
        $transaction = $this->createTransaction(['amount' => -1]);
        
        $this->assertTrue($transaction->isDebit());
    }
    
    /** @test */
    public function is_debit_method_returns_false_when_transaction_amount_is_positive()
    {
        $transaction = $this->createTransaction(['amount' => 1]);
        
        $this->assertFalse($transaction->isDebit());
    }

    /** @test */
    public function is_reconciled_method_returns_true_when_transaction_is_reconciled()
    {
        $credit = $this->createTransaction(['amount' => 100.00]);
        $debit = $this->createTransaction(['amount' => -100.00]);
        $reconciliation = factory(App\Reconciliation::class)->create([
            'credit_id' => $credit->id, 
            'debit_id'  => $debit->id
        ]);
        
        $this->assertTrue($credit->isReconciled());        
    }
}
