<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Contracts\Connections\XeroAPIConnection;

class SyncAccountsWithXero extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xero:accounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import and synchronise your accounts from your Xero account';

    /**
     * The Xero private application adapter
     * 
     * XeroPrivate
     **/
    private $xeroAdapater;
 
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(XeroAPIConnection $xeroAdapter)
    {
        parent::__construct();
        
        $this->xeroAdapter = $xeroAdapter; 
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->xeroAdapter->syncAccounts();
    }
}
