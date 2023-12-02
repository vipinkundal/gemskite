<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DealerController extends Controller
{
    /**
     * Show dealer page
     */
    public function showAddDealerPage()
    {
        return Inertia::render('Master/AddDealer');
    }

    /**
     * Show dealer list page
     */
    public function showManageDealerPage()
    {
        $dealers = Dealer::orderBy('id')->get();

        return Inertia::render('Master/ManageDealer', [
            'dealers' => $dealers,
        ]);
    }

    /**
     * Edit  Dealer
     */
    public function editDealer(Dealer $dealer, Request $request)
    {
        return Inertia::render('Master/AddDealer', ['dealer' => $dealer]);
    }

    /**
     * Delete dealer
     */
    public function deleteDealer(Dealer $dealer, Request $request)
    {
        $dealer->delete();
        $dealer = Dealer::orderBy('id')->get();

        return response()->json(['success' => [
            'dealer' => $dealer,
        ]]);
    }

    /**
     * Save new dealer
     */
    public function createOrUpdateDealer(Request $request)
    {

        if ($request->edit && $request->id) {
            Dealer::where('id', $request->id)->update([
                'name' => $request->name,
                'firm_name' => $request->firm_name,
                'city' => $request->city,
                'state' => $request->state,
                'phone' => $request->phone,
                'email' => $request->email,
                'gst_details' => $request->gst_details,
                'address' => $request->address,
            ]);
        } else {
            Dealer::create([
                'name' => $request->name,
                'firm_name' => $request->firm_name,
                'city' => $request->city,
                'state' => $request->state,
                'phone' => $request->phone,
                'email' => $request->email,
                'gst_details' => $request->gst_details,
                'address' => $request->address,
            ]);
        }

        return redirect('master/add-dealer')->with('success', 'Added Dealer');
    }

    /**
     * Show product list page
     */
    public function getDealersList(Request $request)
    {

        $dealer = Dealer::orderBy('id')->get();
        if (! empty($request->searchBy)) {
            $dealer = Dealer::orderBy('id')->where('name', 'LIKE', '%'.$request->searchBy.'%')
                ->orderBy('id')->get();
        }

        return response()->json(['success' => [
            'dealer' => $dealer,
        ]]);
    }
}
