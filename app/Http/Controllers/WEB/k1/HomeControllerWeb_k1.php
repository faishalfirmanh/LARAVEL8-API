<?php

namespace App\Http\Controllers\WEB\k1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeControllerWeb_k1 extends Controller
{
    //
    public function index()
    {
        return view('K1.Home.index');
    }

    public function Admin()
    {
        return "dd";
    }
}
