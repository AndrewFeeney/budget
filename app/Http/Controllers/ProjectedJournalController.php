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
        return view('projected-journal.index', [
            'projectedJournals' => ProjectedJournal::orderBy('date', 'desc')->paginate(50)
        ]);
    }
}
