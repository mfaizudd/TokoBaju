<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $products = DB::select('select * from products limit 12');
        return view('customer.index', ['products' => $products]);
    }
}
