<?php

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Calculators\CashflowProjector;
use App\Calculators\DateCalculator;

class CashflowCalculationTest extends TestCase
{
    use CreatesModels;
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_calculate_the_projected_cashflow_for_the_financial_year()
    {
        // Generate the income
        $this->createIncome(['amount' => 500, 'date' => Carbon::yesterday()]);

        // Assert that the projected cashflow equals the total income
        $this->assertEquals(
            500,
            app(CashflowProjector::class)->projectedCashflowForPeriod(
                app(DateCalculator::class)->getThisFinancialYear()
            )
        );
    }
}
