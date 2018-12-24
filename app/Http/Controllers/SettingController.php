<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Show the settings page (serves as create route as well)
     **/
    public function index()
    {
        return view('setting.index', ['bankAccounts' => Account::bankAccounts()->get()]);
    }

    public function store()
    {
        Setting::store('selectedBankAccounts', collect(request()->selected_bank_accounts)->keys());
    }
}
