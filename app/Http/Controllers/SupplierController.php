<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\PDF;

class SupplierController extends Controller
{
    /**
     * Show supplier page
     */
    public function showAddSupplierPage()
    {
        $message = session()->get('success');

        return Inertia::render('Master/AddSupplier', [
            'message' => $message,
        ]);
    }

    /**
     * Show supplier list page
     */
    public function showManageSupplierPage()
    {
        $suppliers = Supplier::orderBy('id')->get();

        return Inertia::render('Master/ManageSupplier', [
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Edit  Supplier
     */
    public function editSupplier(Supplier $supplier, Request $request)
    {
        return Inertia::render('Master/AddSupplier', ['supplier' => $supplier]);
    }

    /**
     * Delete supplier
     */
    public function deleteSupplier(Supplier $supplier, Request $request)
    {
        $supplier->delete();
        $supplier = Supplier::orderBy('id')->get();

        return response()->json(['success' => [
            'supplier' => $supplier,
        ]]);
    }

    /**
     * Save new supplier
     */
    public function createOrUpdateSupplier(Request $request)
    {
        if ($request->edit && $request->id) {
            Supplier::where('id', $request->id)->update([
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
            Supplier::create([
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

        return redirect('master/add-supplier')->with('success', 'Supplier added');
    }

    /**
     * Get Dealer List
     */
    public function getSuppliersList(Request $request)
    {

        $supplier = Supplier::orderBy('id')->get();
        if (! empty($request->searchBy)) {
            $supplier = Supplier::orderBy('id')->where('name', 'LIKE', '%'.$request->searchBy.'%')
                ->orderBy('id')->get();
        }

        return response()->json(['success' => [
            'supplier' => $supplier,
        ]]);
    }
    public function viewSupplierInvoice(int $id) {
        // dd($id);
        $order = Supplier::find($id);
        // echo "<pre>";
        // print_r($order);
        // echo "</pre>";
        // die;
        return view("invoice.generate-dealer-invoice",compact('order'));
    }
    public function generateSupplierInvoice($id)
{
    $order = Supplier::find($id);
    $pdf = PDF::loadView('invoice.generate-dealer-invoice', compact('order'));

    // Return the PDF as a download
    return $pdf->download('invoice'.$order->id.'.pdf');
}

    
}
