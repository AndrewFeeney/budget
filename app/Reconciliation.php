<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reconciliation extends Model
{
    protected $fillable = [
        'credit_id',
        'debit_id',
    ];

    /**
     * A reconciliation has one credit transaction
     **/
    public function credit()
    {
        return $this->belongsTo('App\Transaction');
    }

    /**
     * A reconciliation has one debit transaction
     **/
    public function debit()
    {
        return $this->belongsTo('App\Transaction');
    }
}
