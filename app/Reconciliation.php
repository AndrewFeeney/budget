<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reconciliation extends Model
{
    protected $fillable = [
        'credit_id',
        'debit_id',
    ];
}
