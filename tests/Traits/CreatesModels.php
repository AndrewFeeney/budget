<?php

use App\Account;
use App\Reconciliation;
use App\User;

trait CreatesModels
{
    /**
     * Creates an account model and returns it
     *
     * @param array $attributes
     * @return App\Account
     **/
    public function createAccount($attributes = [])
    {
        return factory(Account::class)->create($attributes);
    }

    /**
     * Creates a user, logs them in and returns the user model
     *
     * @param $attributes
     * @return App\User
     **/
    public function createAndLoginUser($attributes = [])
    {
        $user = factory(User::class)->create($attributes);

        \Auth::login($user);

        return $user;
    }

    /**
     * Creates a pair of balanced and opposing transactions which are not reconciled
     * and returns them in an array with the 'credit' key containing to the positive
     * transaction and the 'debit' key containing the negative transaction.
     *
     * @return array
     **/
    public function createTransactionPair()
    {
        // Create account for credit transaction
        $creditAccount = $this->createAccount();

        // Create credit transaction
        $creditTransaction = $this->createTransaction([
            'account_id' => $creditAccount->id,
        ]);

        // Ensure transaction is positive by taking it's absolute value
        $creditTransaction->amount = abs($creditTransaction->amount);
        $creditTransaction->save();
        
        // Create account for debit transaction
        $debitAccount = $this->createAccount();

        // Create debit transaction
        $debitTransaction = $this->createTransaction([
            'account_id' => $debitAccount,
            'amount' => -$creditTransaction->amount
        ]);

        return [
            'credit' => $creditTransaction,
            'debit' => $debitTransaction
        ];
    }
}
