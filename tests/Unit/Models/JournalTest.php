<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Journal;
use Carbon\Carbon;

class JournalTest extends TestCase
{
    use CreatesModels;
    use DatabaseMigrations;

    /** @test */
    public function amount_method_returns_total_cashflow_represented_by_journal()
    {
        $journal = $this->createAccountsReceivablePayment(['gross_amount' => 100]);
        $this->assertEquals(100, $journal->amount());
    }

    /** @test */
    public function between_dates_scope_returns_journals_between_dates()
    {
        $includedJournal = $this->createJournal([
            'date' => '2000-01-01 00:00:00'
        ]);

        $excludedJournalBefore = $this->createJournal([
            'date' => '1998-01-01 00:00:00'
        ]);

        $excludedJournalAfter = $this->createJournal([
            'date' => '2002-01-01 00:00:00'
        ]);

        $journals = Journal::betweenDates(
            Carbon::parse('1999-01-01 00:00:00'),
            Carbon::parse('2001-01-01 00:00:00')
        )->get();

        // Assert that the included journal is returned in the query
        $this->assertTrue($journals->contains(function ($journal) use ($includedJournal) {
            return $journal->id == $includedJournal->id;
        }));
        // Assert that journal before the date is not included
        $this->assertFalse($journals->contains(function ($journal) use ($excludedJournalBefore) {
            return $journal->id == $excludedJournalBefore->id;
        }));
        // Assert that journal after the date is not included
        $this->assertFalse($journals->contains(function ($journal) use ($excludedJournalAfter) {
            return $journal->id == $excludedJournalAfter->id;
        }));
    }
}
