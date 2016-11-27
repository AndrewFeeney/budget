<?php

namespace App\Contracts\Connections;

interface XeroAPIConnection
{
    /**
     * Fetch Xero accounts from Xero API and sync them against those stored in the local database
     **/
    public function syncAccounts();
    
    /**
     * Fetch Xero journals from Xero API and sync them against those stored in the local database
     **/
    public function syncJournals();
}
