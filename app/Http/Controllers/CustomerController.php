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

    public function cart(Request $request)
    {
        $cartItems = $request->session()->get('cart');
        $items = [];
        foreach ($cartItems as $value) {
            $items[] = DB::selectOne('
                select m.id, p.name, p.brand, concat(m.size, " - ", m.color) as model, m.price, :qty
                from product_models m
                join products p on m.product_id = p.id
                where m.id = :model_id
            ', [
                'qty' => $value['qty'],
                'model_id' => $value['id']
            ]);
        }
        return view('customer.products.cart', ['items' => $items]);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|exists:product_models,id',
            'qty' => 'required|numeric|min:1'
        ]);
        $products = DB::select('select * from products');
        $model = DB::selectOne('select * from product_models where id = ?', [$request->id]);
        $product = DB::selectOne('select * from products where id = ?', [$model->product_id]);

        $cartItem = [
            'id' => $model->id,
            'qty' => $request->qty,
        ];
        $request->session()->push('cart', $cartItem);
        return view('customer.index', ['products' => $products, 'addedProduct' => $product]);
    }
}
