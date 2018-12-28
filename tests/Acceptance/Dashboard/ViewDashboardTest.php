<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class ViewDashboardTest extends BrowserKitTestCase
{
    use CreatesModels;
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_see_their_cash_balance_on_the_dashboard()
    {
        $this->createIncome(['amount' => 500]);

        $this->createAndLoginUser();

        $this->visit(route('home'))
            ->see('500');
    }
}
