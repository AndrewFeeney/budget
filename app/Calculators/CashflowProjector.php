<?php

namespace App\Calculators;

use App\Models\Journal;
use App\Models\ProjectedJournal;
use Carbon\Carbon;

class CashflowProjector
{
    /**
     * Returns the user's projected cashflow for the given period
     * @param \DatePeriod
     * @return float
     **/
    public function projectedCashFlowForPeriod(\DatePeriod $period)
    {
        // Sum journals from between start of period and now
        $sumOfJournals = Journal::betweenDates($period->start, Carbon::now())
            ->get()
            ->sum(function ($journal) {
                return $journal->amount();
            });

        // Sum projected journals from between now and end of period
        $sumOfProjectedJournals = ProjectedJournal::where(
            'date', '>', $period->start->format('Y-m-d')
        )->where('date', '<', \Carbon\Carbon::today()->format('Y-m-d'))
            ->get()
            ->sum(function ($journal) {
                return $journal->amount();
            });

        return $sumOfJournals + $sumOfProjectedJournals;
    }
}
