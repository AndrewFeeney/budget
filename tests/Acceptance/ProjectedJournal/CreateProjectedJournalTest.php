<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\ProjectedJournal;

class CreateProjectedJournalTest extends TestCase
{
    use CreatesModels;
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_create_a_projected_journal()
    {
        // Create user and sign in
        $user = $this->getTestObject('user');
        Auth::login($user);

        // Create accounts
        $toAccount = $this->createAccount();
        $fromAccount = $this->createAccount();

        // Visit projections create page
        $this->visit(route('projected-journal.create'));

        // Fill out form
        $this->type('2017-01-01 09:00:00', 'date')
            ->select($fromAccount->id, 'from_account_id')
            ->select($toAccount->id, 'to_account_id')
            ->select('CASHPAID', 'source_type')
            ->type('123.45', 'amount')
            ->type('Projected Journal', 'reference')
            ->press('Create Projection');

        // See that we are redirected to expected page
        $this->seePageIs(route('projected-journal.index'));

        // See the expected result in the database
        $this->seeInDatabase('projected_journals', [
            'date' => '2017-01-01 09:00:00',
            'source_type' => 'CASHPAID',
            'reference' => 'Projected Journal'
        ]);

        // Get newly created projected journal from database
        $projectedJournal = ProjectedJournal::orderBy('id', 'desc')->first();

        // Assert that projected journal lines have been created
        $this->seeInDatabase('projected_journal_lines', [
            'projected_journal_id' => $projectedJournal->id,
            'account_id' => $fromAccount->id,
            'amount' => -123.45,
        ]);
        $this->seeInDatabase('projected_journal_lines', [
            'projected_journal_id' => $projectedJournal->id,
            'account_id' => $toAccount->id,
            'amount' => 123.45,
        ]);
    }
}
