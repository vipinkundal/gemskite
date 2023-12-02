<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LedgerController extends Controller
{
    /**
     * Index ledger page
     */
    public function index()
    {
        return Inertia::render('Ledger/LedgerIndex');
    }

    /**
     * Create ledger page
     */
    public function create()
    {
        return Inertia::render('Ledger/LedgerCreate');
    }

    /**
     * Edit  Ledger
     */
    public function editLedger(Ledger $ledger, Request $request)
    {
        return Inertia::render('Ledger/LedgerCreate', ['edit' => $ledger]);
    }

    /**
     * Delete ledger
     */
    public function deleteLedger(Ledger $ledger, Request $request)
    {
        $ledger->softDelete();
        $ledgers = Ledger::orderBy('id')->get();

        return response()->json(['success' => [
            'ledger' => $ledgers,
        ]]);
    }

     /**
     * Save new legder
     */
    public function createOrUpdateLedger(Request $request)
    {
        $date_time = Carbon::createFromFormat('Y-m-d\TH:i:s.v\Z', $request->date);
        $date_time->setTimezone('Asia/Kolkata');
        if ($request->edit && $request->id) {
            Ledger::where('id', $request->id)->update([
                'name' => $request->name,
                'date' => $date_time,
                'mobile_number' => $request->mobile_number,
                'address' => $request->address,
                'state' => $request->state,
                'country' => $request->country,
                'type' => $request->type,
                'opening_balance' => $request->opening_balance,
            ]);
        } else {
            Ledger::create([
                'name' => $request->name,
                'date' => $date_time,
                'mobile_number' => $request->mobile_number,
                'address' => $request->address,
                'state' => $request->state,
                'country' => $request->country,
                'type' => $request->type,
                'opening_balance' => $request->opening_balance,
            ]);
        }

        return redirect('ledger/index')->with('success', 'Ledger added!');
    }

    /**
     * Show product list page
     */
    public function getLedgersList(Request $request)
    {

        $ledger = Ledger::orderBy('id')->get();
        if (! empty($request->searchBy)) {
            $ledger = Ledger::orderBy('id')->where($request->searchType, 'LIKE', '%'.$request->searchBy.'%')
                ->orderBy('id')->get();
        }

        return response()->json(['success' => [
            'ledger' => $ledger,
        ]]);
    }
}
