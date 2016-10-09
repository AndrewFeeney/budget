<?php

namespace App\Connections;

use XeroPrivate;

class ConnectsWithXeroAPI
{
    public function __construct(XeroPrivate $xeroApp)
    {
        $this->xeroApp = $xeroApp;
    }
}
