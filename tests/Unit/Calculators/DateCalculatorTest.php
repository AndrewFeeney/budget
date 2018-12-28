<?php


use App\Calculators\DateCalculator;
use Carbon\Carbon;

class DateCalculatorTest extends BrowserKitTestCase
{
    /** @test */
    public function get_start_of_this_financial_year_returns_1st_july_from_year_previous_on_1st_jan()
    {
        Carbon::setTestNow(Carbon::parse('1st January 2017 9:00:00am'));

        $calculator = app(DateCalculator::class);
        $this->assertEquals(
            '2016-07-01 00:00:00',
            $calculator->getStartOfThisFinancialYear()->format('Y-m-d H:i:s')
        );

        Carbon::setTestNow();
    }

    /** @test */
    public function get_start_of_this_financial_year_returns_1st_july_from_current_year_on_31st_dec()
    {
        Carbon::setTestNow(Carbon::parse('31st December 2016 9:00:00am'));

        $calculator = app(DateCalculator::class);
        $this->assertEquals(
            '2016-07-01 00:00:00',
            $calculator->getStartOfThisFinancialYear()->format('Y-m-d H:i:s')
        );

        Carbon::setTestNow();
    }

    /** @test */
    public function get_end_of_this_financial_year_returns_30th_june_from_current_year_on_1st_jan()
    {
        Carbon::setTestNow(Carbon::parse('1st January 2017 9:00:00am'));

        $calculator = app(DateCalculator::class);
        $this->assertEquals(
            '2017-06-30 00:00:00',
            $calculator->getEndOfThisFinancialYear()->format('Y-m-d H:i:s')
        );

        Carbon::setTestNow();
    }

    /** @test */
    public function get_end_of_this_financial_year_returns_30th_june_from_next_year_on_31st_dec()
    {
        Carbon::setTestNow(Carbon::parse('31st December 2016 9:00:00am'));

        $calculator = app(DateCalculator::class);
        $this->assertEquals(
            '2017-06-30 00:00:00',
            $calculator->getEndOfThisFinancialYear()->format('Y-m-d H:i:s')
        );

        Carbon::setTestNow();
    }

    /** @test */
    public function get_this_financial_year_returns_expected_result_on_1st_jan()
    {
        Carbon::setTestNow(Carbon::parse('1st January 2017 9:00:00am'));

        $calculator = app(DateCalculator::class);

        $financialYear = $calculator->getThisFinancialYear();

        $this->assertEquals(
            '2016-07-01 00:00:00',
            $financialYear->getStartDate()->format('Y-m-d H:i:s')
        );

        $this->assertEquals(
            '2017-06-30 00:00:00',
            $financialYear->getEndDate()->format('Y-m-d H:i:s')
        );

        Carbon::setTestNow();
    }

    /** @test */
    public function get_this_financial_year_returns_expected_result_on_31st_dec()
    {
        Carbon::setTestNow(Carbon::parse('31st December 2016 9:00:00am UTC'));

        $calculator = app(DateCalculator::class);

        $financialYear = $calculator->getThisFinancialYear();

        $this->assertEquals(
            '2016-07-01 00:00:00',
            $financialYear->getStartDate()->format('Y-m-d H:i:s')
        );

        $this->assertEquals(
            '2017-06-30 00:00:00',
            $financialYear->getEndDate()->format('Y-m-d H:i:s')
        );
    }
}
