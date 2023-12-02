<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

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
}
