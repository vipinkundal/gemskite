<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\OutwardEntry;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesController extends Controller
{
    /**
     * Index ledger page
     */
    public function index()
    {
        return Inertia::render('Sales/SalesIndex');
    }

    /**
     * Create ledger page
     */
    public function create()
    {
        return Inertia::render('Sales/SalesCreate');
    }

    /**
     * Edit ledger page
     */
    public function edit()
    {
        return Inertia::render('Sales/SalesCreate');
    }


    public function viewSalesInvoice(int $id) {
        // dd($id);
        $order = OutwardEntry::find($id);
        // echo "<pre>";
        // print_r($order);
        // echo "</pre>";
        // die;
        return view("invoice.generate-outward-invoice",compact('order'));
    }
    public function generateSalesInvoice($id) {
        $order = OutwardEntry::find($id);
        $pdf = PDF::loadView('invoice.generate-outward-invoice', compact('order'));

    // Return the PDF as a download
    return $pdf->download('invoice'.$order->id.'.pdf');
    }
}
