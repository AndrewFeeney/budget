<?php

use Carbon\Carbon;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Creates a new account model and associated models and returns it
     *
     * @return App\Models\Account
     **/
    public function createAccount($data = [])
    {
        return factory(App\Models\Account::class)->create($data);
    }

    /**
     * Creates a new reconciliation model and associated models and returns it
     *
     * @return App\Models\Account
     **/
    public function createReconciliation($data = [])
    {
        $credit = $this->createTransaction();
        $debit = $this->createTransaction(['amount' => $credit->balance()]);
        return factory(App\Reconciliation::class)->create([
            'credit_id' => $credit->id,
            'debit_id' => $debit->id
        ] + $data);
    }

    /**
     * Creates a new transaction model and associated models and returns it
     *
     * @return App\Transaction
     **/
    public function createTransaction($data = [])
    {
        // Create account
        $account = $this->createAccount();

        // Create and return transaction
        return factory(App\Transaction::class)->create(['account_id' => $account->id] + $data);
    }

    /**
     * Creates a new user model and returns it
     *
     * @return App\User
     **/
    public function createUser($data = [])
    {
        return factory(App\User::class)->create($data);
    }

    public function tearDown()
    {
        parent::tearDown();

        // Reset Carbon
        Carbon::setTestNow();
    }
}
