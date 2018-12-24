<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalLine extends Model
{
    protected $guarded = [];

    /**
     *  A Journal belongs to an account
     **/
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_xero_id', 'xero_id');
    }
}
