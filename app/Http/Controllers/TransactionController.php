<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function overview(Request $request)
    {
        $cartItems = $request->session()->get('cart', []);
        $items = [];
        foreach ($cartItems as $value) {
            $items[] = DB::selectOne('
                select p.id, p.name, p.brand, concat(m.size, " - ", m.color) as model, m.price, :qty as qty, m.id as model_id
                from product_models m
                join products p on m.product_id = p.id
                where m.id = :model_id
            ', [
                'qty' => $value['qty'],
                'model_id' => $value['id']
            ]);
        }
        $customerAddresses = DB::select('select * from customer_addresses where user_id = ?', [Auth::user()->id]);
        return view('customer.transactions.overview', ['items' => $items, 'addresses' => $customerAddresses]);
    }

    public function buy(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        DB::insert('insert transactions(date, discount, address, shipping_cost, customer_id) values(:date, :discount, :address, :shipping_cost, :customer_id)', [
            'date' => $request->date
        ]);
    }
}
