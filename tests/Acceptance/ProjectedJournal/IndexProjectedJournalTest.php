<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IndexProjectedJournalTest extends TestCase
{
    use CreatesModels;
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_visit_the_index_projected_journal_page()
    {
        $projectedJournal = $this->getTestObject('projectedJournal');

        $this->createAndLoginUser();

        $this->visit(route('projected-journal.index'));

        $this->assertResponseOk();

        $this->seePageIs(route('projected-journal.index'));

        $this->see('Projected Journals')
            ->see($projectedJournal->name);
    }
}
