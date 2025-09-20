<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.dashboard');
    }

    public function empty()
    {
        return view('pages.dashboard.emptyDashboard');
    }
}
