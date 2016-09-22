<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Reconciliation;
use App\Transaction;

class ReconciliationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Transaction $transaction)
    {
        return view('transaction.reconciliation.create', [
            'transaction' => $transaction,
            'candidates' => $transaction->reconciliationCandidates()
                ->keyBy('id')
                ->map( function($candidate) {
                    return $candidate->date . ' ' . $candidate->outputValue() . ' ' . $candidate->reference;
                })
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Transaction $transaction)
    {
        $this->validate($request, [
            'reconciled_transaction_id' => 'required|exists:transactions,id'
        ]);

        if ($transaction->isCredit()) {
            $creditId = $transaction->id;
            $debitId = $request->reconciled_transaction_id;
        }
        else {
            $debitId = $transaction->id;
            $creditId = $request->reconciled_transaction_id;
        }

        Reconciliation::create([
            'credit_id' => $creditId,
            'debit_id' => $debitId
        ]);

        return redirect()
            ->route('transaction.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
