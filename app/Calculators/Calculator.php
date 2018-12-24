<?php

namespace App\Calculators;

use App\Models\Journal;

class Calculator
{
    /**
     * Returns the user's total cash balance
     **/
    public function getCashBalance()
    {
        return Journal::all()
            ->sum(function ($journal) {
                return $journal->amount();
            });
    }
}
