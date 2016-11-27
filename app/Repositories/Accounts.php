<?php

namespace App\Repositories;

use XeroPHP\Models\Accounting\Account as XeroAccount;

use App\Models\Account;

class Accounts extends Repository
{
    public function __construct(Account $model)
    {
        $this->model = $model;
    }

    /**
     * Takes the given xero Account object and syncs it with the matching local Account object
     * or creates a new one and saves it to the database
     *
     * @param XeroPHP\Models\Accounting\Account $xeroAccount
     * @return App\Models\Account
     **/
    public function sync(XeroAccount $xeroAccount)
    {
        // Convert Xero Account object to an array
        $accountData = $xeroAccount->toStringArray();

        // Update the account entry with a matching account_id or create it if it does
        // not yet exist
        return Account::updateOrCreate(['xero_id' => $accountData['AccountID'],], [
            'code' => $accountData['Code'] ?? null,
            'name' => $accountData['Name'],
            'type' => $accountData['Type'],
            'bank_account_number' => $accountData['BankAccountNumber'] ?? null,
            'bank_account_type' => $accountData['BankAccountType'] ?? null,
            'status' => $accountData['Status'],
            'description' => $accountData['Description'] ?? null,
            'currency_code' => $accountData['CurrencyCode'] ?? null,
            'tax_type' => $accountData['TaxType'],
            'is_system_account' => isset($accountData['SystemAccount'])
        ]);
    }

    /**
     * Takes the given array of Account objects and syncs them with those stored
     * in the local database
     *
     * @param array $accounts
     **/
    public function syncMultiple($accounts)
    {
        collect($accounts)->each(function ($account) {
            $this->sync($account);
        });
    }
}
