<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\ProjectedJournal;
use App\Models\ProjectedJournalLine;
use App\Models\Account;

class ProjectedJournalController extends Controller
{
    /**
     * Shows the projected journals list view
     **/
    public function index()
    {
        return view('projectedJournal.index', [
            'projectedJournals' => ProjectedJournal::orderBy('date', 'desc')->paginate(50)
        ]);
    }

    /**
     * Shows the form to create a projected journal
     **/
    public function create()
    {
        $accounts = Account::orderBy('code', 'asc')
            ->get()
            ->map(function ($account) {
                return [
                    'id' => $account->id,
                    'name' => $account->code . ' ' . $account->name
                ];
            })->pluck('name', 'id');

        $sourceTypes = collect(ProjectedJournal::SOURCE_TYPES);

        return view('projectedJournal.create', compact(['accounts', 'sourceTypes']));
    }

    /**
     * Saves the new projected journal to the database
     **/
    public function store(Request $request)
    {
        // Create the projected journal
        $projectedJournal = ProjectedJournal::create($request->only([
            'date',
            'reference',
            'source_type',
        ]));

        // Create the projected journal lines
        ProjectedJournalLine::create([
            'projected_journal_id' => $projectedJournal->id,
            'account_id' => $request->from_account_id,
            'amount' => -$request->amount,
        ]);
        ProjectedJournalLine::create([
            'projected_journal_id' => $projectedJournal->id,
            'account_id' => $request->to_account_id,
            'amount' => $request->amount,
        ]);
    }
}
