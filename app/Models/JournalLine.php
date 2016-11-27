<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalLine extends Model
{
    protected $fillable = [
        'xero_id',
        'journal_id',
        'account_xero_id',
        'account_type',
        'account_name',
        'description',
        'net_amount',
        'gross_amount',
        'tax_amount',
        'tax_type',
        'tax_name'
    ];
}
