<?php

namespace App\Repositories;

use XeroPHP\Models\Accounting\Account as XeroAccount;

use App\Account;

class Accounts extends Repository
{
    public function __construct(Account $model)
    {
        $this->model = $model;
    }

    /**
     * Takes the given xero Account object and turns it into a local Account object
     * which is saved to the database
     *
     * @param XeroPHP\Models\Accounting\Account $xeroAccount
     * @return App\Account
     **/
    public function saveFromXero(XeroAccount $xeroAccount)
    {
        // Convert Xero Account object to a collection
        $accountData = collect($xeroAccount->toStringArray());

        // Save the array data to a new local Account object
        return Account::create([
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
}
