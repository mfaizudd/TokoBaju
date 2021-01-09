<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = DB::select('
            select t.id, t.date, t.discount, t.address, sum(i.qty * (m.price - m.price * t.discount)) as total
            from transactions t
            join transaction_items i on t.id = i.transaction_id
            join product_models m on i.item_id = m.id
            where customer_id = ?
            group by t.id, t.date, t.discount, t.address', [Auth::user()->id]);

        return view('customer.transactions.index', ['transactions' => $transactions]);
    }

    public function show($id)
    {
        $transaction = DB::selectOne('select * from transactions where id = ?', [$id]);
        $items = DB::select('
            select i.item_id, concat(p.name, " (", m.size, " - ", m.color, ")") as name, i.qty, m.price from transaction_items i
            join product_models m on i.item_id = m.id
            join products p on p.id = m.product_id
            where i.transaction_id = ?', [$id]);

        $total = DB::selectOne('
            select sum(i.qty * (m.price - m.price * t.discount)) as total
            from transactions t
            join transaction_items i on t.id = i.transaction_id
            join product_models m on i.item_id = m.id
            where t.id = ?', [$id])->total;

        return view('customer.transactions.show', [
            'transaction' => $transaction,
            'items' => $items,
            'total' => $total
        ]);
    }

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

    public function checkout(Request $request)
    {
        $validator = Validator::make(array_merge($request->session()->all(), $request->all()), [
            'cart' => 'required|array',
            'cart.*.id' => 'required|numeric',
            'cart.*.qty' => 'required|numeric|min:1',
            'address' => 'required|exists:customer_addresses,id'
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }

        DB::transaction(function () use ($request) {
            $address = DB::selectOne('select * from customer_addresses where id = ?', [$request->address]);
            $cart = $request->session()->get('cart', []);
            DB::insert('insert transactions(date, discount, address, shipping_cost, customer_id) values(:date, :discount, :address, :shipping_cost, :customer_id)', [
                'date' => now(),
                'discount' => 0,
                'address' => $address->address,
                'shipping_cost' => 10000,
                'customer_id' => Auth::user()->id
            ]);
            $id = DB::selectOne('select last_insert_id() as id from transactions')->id;
            foreach ($cart as $item) {
                DB::insert('insert into transaction_items(transaction_id, item_id, qty) values(:transaction_id, :item_id, :qty)', [
                    'transaction_id' => $id,
                    'item_id' => $item['id'],
                    'qty' => $item['qty']
                ]);
            }
            $request->session()->remove('cart');
        });
        return redirect(route('home'));
    }
}
