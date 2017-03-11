<?php

namespace App\Calculators;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use DatePeriod;

class DateCalculator
{
    /**
     * Returns the current Australian financial year (1st July YYYY - 30th June (YYYY + 1))
     * as a DatePeriod object
     *
     * @return DatePeriod
     **/
    public function getThisFinancialYear()
    {
        return new DatePeriod(
            $this->getStartOfThisFinancialYear(),
            CarbonInterval::year(),
            $this->getEndOfThisFinancialYear()
        );
    }

    /**
     * Returns the start date of the curreny Australian financial year as a Carbon object
     *
     * @return Carbon
     **/
    public function getStartOfThisFinancialYear()
    {
        $startOfFinancialYear = Carbon::parse('first day of July');

        // If the current time is in the first half of the current calendar year
        if (intval(Carbon::now()->format('m')) < 6) {
            // Return the 1st of July of last year
            return $startOfFinancialYear->subYear();
        }

        return $startOfFinancialYear;
    }

    /**
     * Returns the start date of the curreny Australian financial year as a Carbon object
     *
     * @return Carbon
     **/
    public function getEndOfThisFinancialYear()
    {
        $startOfFinancialYear = Carbon::parse('June 30th Midnight');

        // If the current time is in the last half of the current calendar year
        if (Carbon::now()->format('i') > 6) {
            // Return the 30th June of next year
            return $startOfFinancialYear->addYear();
        }

        return $startOfFinancialYear;
    }
}

