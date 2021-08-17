<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard');
    }
}
