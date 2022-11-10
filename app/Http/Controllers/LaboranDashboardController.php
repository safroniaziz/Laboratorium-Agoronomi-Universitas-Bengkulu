<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaboranDashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function dashboard(){
        return view('laboran.dashboard');
    }
}
