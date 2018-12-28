<?php

use App\Models\Setting;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateSettingTest extends BrowserKitTestCase
{
    use CreatesModels;
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_save_their_selected_bank_accounts()
    {
        $account = $this->createBankAccount();

        $this->createAndLoginUser();

        $this->visit(route('setting.index'));

        $this->seePageIs(route('setting.index'));

        $this->check('selected_bank_accounts['.$account->xero_id.']');

        $this->press('Save');

        $this->assertResponseOk();

        $this->assertEquals(
            [$account->xero_id],
            Setting::retrieve('selectedBankAccounts')->toArray()
        );
    }
}
