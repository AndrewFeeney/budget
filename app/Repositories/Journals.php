<?php

namespace App\Repositories;

use Carbon\Carbon;
use XeroPHP\Models\Accounting\Journal as XeroJournal;

use App\Models\Journal;
use App\Repositories\JournalLines;

class Journals extends Repository
{
    private $journalLines;

    public function __construct(Journal $model, JournalLines $journalLines)
    {
        $this->model = $model;
        $this->journalLines = $journalLines;
    }

    /**
     * Takes the given xero Journal object and syncs it with the matching local Journal object
     * or creates a new one and saves it to the database
     *
     * @param XeroPHP\Models\Accounting\Journal $xeroJournal
     * @return App\Journal
     **/
    public function sync(XeroJournal $xeroJournal)
    {
        // Convert Xero Journal object to an array
        $journalData = $xeroJournal->toStringArray();
        
        // Convert dates from ISO 8601 format
        $date = Carbon::createFromFormat('Y-m-d\TH:i:sP', $journalData['JournalDate']);
        $createdDate = Carbon::createFromFormat('Y-m-d\TH:i:sP', $journalData['CreatedDateUTC']);

        // Update the journal entry with a matching journal_id or create it if it does
        // not yet exist
        $journal = Journal::updateOrCreate(['xero_id' => $journalData['JournalID'],], [
            'date' => $date,
            'number' => $journalData['JournalNumber'],
            'created_date_utc' => $createdDate,
            'reference' => $journalData['Reference'] ?? null,
            'source_xero_id' => $journalData['SourceID'] ?? null,
            'source_type' => $journalData['SourceType'] ?? null,
        ]);

        // Sync journal lines
        $this->journalLines->syncMultiple($journalData['JournalLines'], $journal);

        return $journal;
    }

    /**
     * Takes the given array of Journal objects and syncs them with those stored
     * in the local database
     *
     * @param array $journals
     **/
    public function syncMultiple($journals)
    {
        collect($journals)->each(function ($journal) {
            $this->sync($journal);
        });
    }
}
