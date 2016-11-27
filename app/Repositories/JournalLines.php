<?php

namespace App\Repositories;

use App\Models\Journal;
use App\Models\JournalLine;

class JournalLines extends Repository
{
    public function __construct(JournalLine $model)
    {
        $this->model = $model;
    }

    /**
     * Takes the given JournalLine array and syncs it with the matching local Journal object
     * or creates a new one and saves it to the database
     *
     * @param array $xeroJournalLine
     * @return App\Models\JournalLine
     **/
    public function sync($xeroJournalLine, Journal $journal)
    {
        // Update the journal entry with a matching journal_id or create it if it does
        // not yet exist
        $journalLine = JournalLine::updateOrCreate(['xero_id' => $xeroJournalLine['JournalLineID']], [
            'journal_id' => $journal->id,
            'account_xero_id' => $xeroJournalLine['AccountID'],
            'account_code' => $xeroJournalLine['AccountCode'] ?? null,
            'account_type' => $xeroJournalLine['AccountType'],
            'account_name' => $xeroJournalLine['AccountName'],
            'description' => $xeroJournalLine['Description'] ?? null,
            'net_amount' => $xeroJournalLine['NetAmount'],
            'gross_amount' => $xeroJournalLine['GrossAmount'],
            'tax_amount' => $xeroJournalLine['TaxAmount'],
            'tax_type' => $xeroJournalLine['TaxType'] ?? null,
            'tax_name' => json_encode($xeroJournalLine['TaxName'] ?? null),
        ]);
        
        return $journalLine;
    }

    /**
     * Takes the given array of JournalLine objects and syncs them with those stored
     * in the local database
     *
     * @param array $journalLines
     **/
    public function syncMultiple($journalLines, Journal $journal)
    {
        collect($journalLines)->each(function ($journalLine) use ($journal) {
            $this->sync($journalLine, $journal);
        });
    }
}
