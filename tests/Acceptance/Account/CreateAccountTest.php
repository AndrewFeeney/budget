<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateAccountTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function a_logged_in_user_can_create_an_account()
    {
        $user = $this->createUser();

        auth()->login($user);

        $this->visit(route('account.create'))
            ->seePageIs(route('account.create'));

        $this->type('Test Account Name', 'name')
            ->type('Test Account Description', 'description')
            ->select('Bank Account', 'type')
            ->press('Create');
        
        $this->seePageIs(route('account.index'));

        $this->seeInDatabase('accounts', [
            'name' => 'Test Account Name',
            'description' => 'Test Account Description',
            'type' => 'Bank Account',
        ]);
    }
}
