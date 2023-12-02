<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class MasterController extends Controller
{
    /**
     * Show Create User
     *
     * @return void
     */
    public function showCreateUser()
    {
        return Inertia::render('Master/CreateUser');
    }

    /**
     * Show manager units
     *
     * @return void
     */
    public function showManageUnits()
    {
        return Inertia::render('Master/ManageUnits');
    }
}
