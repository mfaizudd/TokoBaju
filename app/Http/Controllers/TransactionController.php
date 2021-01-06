<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function overview()
    {
        // TODO: add final overview for customer, showing their address, shipping cost etc
    }

    public function buy(Request $request)
    {
        $cart = $request->session()->get('cart');
        DB::insert('insert transactions(date, discount, address, shipping_cost, customer_id) values(:date, :discount, :address, :shipping_cost, :customer_id)', [
            'date' => $request->date
        ]);
    }
}
