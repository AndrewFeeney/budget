<?php

namespace App\Connections;

use App\Contracts\Connections\XeroAPIConnection;
use App\Repositories\Accounts;
use App\Repositories\Journals;

class ConnectsWithXeroAPI implements XeroAPIConnection
{
    /**
     * Accounts repository
     *
     * @var App\Repositories\Accounts
     **/
    private $accounts;

    /**
     * Journals repository
     *
     * @var App\Repositories\Journals
     **/
    private $journals;
    
    /**
     * Xero application
     *
     * @var XeroPHP\Application\PrivateApplication
     **/
    private $xeroApp;

    public function __construct(Accounts $accounts, Journals $journals)
    {
        $this->accounts = $accounts;
        $this->journals = $journals;
        $this->xeroApp = app()->make('XeroPrivate');
    }

    /**
     * Fetch Xero accounts from Xero API and sync them against those stored in the local database
     **/
    public function syncAccounts()
    {
        // Fetch accounts from Xero API
        $xeroAccounts = collect($this->xeroApp
            ->load("Accounting\\Account")
            ->execute()
        );

        // Sync accounts with Accounts stored in database
        $this->accounts->syncMultiple($xeroAccounts);
    }

    /**
     * Fetch Xero journals from Xero API and sync them against those stored in the local database
     **/
    public function syncJournals()
    {
        // First we need to make sure the accounts are in sync
        $this->syncAccounts();

        // Next we'll sync the journals 
        $xeroJournals = $this->syncAllObjectsOfType('Journal');
    }

    /**
     * Fetch from the Xero API all objects of given type and return them as collection
     *
     * @param string $objectType
     * @return Illuminate\Support\Collection
     **/
    private function syncAllObjectsOfType($objectType)
    {
        // Instantiate collection for results
        $results = collect();

        // Declare offset counter
        $offset = 0;

        // Keep getting results while we get 100 back
        do {
            // Get 100 journals
            $result = collect($this->xeroApp
                ->load("Accounting\\$objectType")
                ->offset($offset * 100)
                ->execute());
            
            // Sync accounts with Accounts stored in database
            $this->journals->syncMultiple($result);

            // Increment offset    
            $offset++;

            dump($offset * 100);
        } while ($result->count() == 100);
    }
}
