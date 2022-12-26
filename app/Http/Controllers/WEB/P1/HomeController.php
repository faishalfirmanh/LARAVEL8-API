<?php

namespace App\Http\Controllers\WEB\P1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\P1\Product;

class HomeController extends Controller
{
    //
    public function index()
    {
        $p = Product::all();
        return view('p1.home_p1',['p'=>$p]);
    }
}
