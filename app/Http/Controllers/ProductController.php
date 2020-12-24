<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = DB::select('select * from products');
        return view('admin.product.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = DB::select('select * from categories');
        return view('admin.product.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'brand' => 'required|string'
        ]);
        DB::transaction(function () use ($request) {
            DB::insert('insert into products(name, brand) values(?, ?)', [$request->input('name'), $request->input('brand')]);
            $id = DB::select('select last_insert_id() as id')[0]->id;
            $categories = [];
            foreach ($request->input('categories', []) as $value) {
                $categories[$value] = null;
            }
            foreach ($categories as $key => $value) {
                DB::insert('insert into product_categories(product_id, category_id) values(?, ?)', [$id, $key]);
            }
        });
        return redirect(route('admin.product.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = DB::select('select * from products where id = ?', [$id])[0];
        return view('admin.product.show', ['product'=>$product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = DB::select('select * from categories');
        $product = DB::select('select * from products where id = ?', [$id])[0];
        $productCategories = DB::select('select * from product_categories where product_id = ?', [$id]);
        return view('admin.product.edit', ['product'=>$product, 'productCategories' => $productCategories, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'brand' => 'required|string',
        ]);
        DB::transaction(function () use ($request, $id) {
            DB::update('update products set name = ?, brand = ? where id = ?', [$request->input('name'), $request->input('brand'), $id]);

            // Reset categories
            DB::delete('delete from product_categories where product_id = ?', [$id]);

            // Update categories
            $categories = [];
            foreach ($request->input('categories', []) as $value) {
                $categories[$value] = null;
            }
            foreach ($categories as $key => $value) {
                DB::insert('insert into product_categories(product_id, category_id) values(?, ?)', [$id, $key]);
            }
        });

        return redirect(route('admin.product.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from products where id = ?', [$id]);
        return redirect(route('admin.product.index'));
    }
}
