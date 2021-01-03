<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        if (Auth::user() == null)
        {
            return view('welcome');
        }

        $products = DB::select('select * from products limit 12');
        return view('customer.index', ['products' => $products]);
    }

    public function showProduct($id)
    {
        $product = DB::selectOne('select * from products where id = ?', [$id]);
        $models = DB::select('select * from product_models where product_id = ?', [$id]);

        return view('customer.products.show', [
            'product' => $product,
            'models' => $models
        ]);
    }
}
