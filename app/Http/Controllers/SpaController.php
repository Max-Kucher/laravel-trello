<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class SpaController extends Controller
{
    public function index(Request $req) : View
    {
        return view('index');
    }
}
