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
        $startOfFinancialYear = Carbon::parse('July')
            ->startOfMonth()
            ->startOfDay();

        while ($startOfFinancialYear->gt(Carbon::now())) {
            $startOfFinancialYear->subYear();
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
        $endOfFinancialYear = (new Carbon('June '.Carbon::now()->year))
            ->endOfMonth()
            ->startOfDay();

        while ($endOfFinancialYear->lt(Carbon::now())) {
            $endOfFinancialYear->addYear();
        }

        return $endOfFinancialYear;
    }
}
