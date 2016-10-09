<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Repositories\Accounts;

class ImportAccountsFromXero extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xeroimport:accounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $accounts, $xeroApp;
 
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->xeroApp = app()->make('XeroPrivate');
        $this->accounts = app()->make('App\Repositories\Accounts');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $xeroAccounts = $this->xeroApp
            ->load('Accounting\\Account')
            ->execute();
        
        collect($xeroAccounts)->each( function($account) {
            $this->accounts->saveFromXero($account);
        });
    }
}
