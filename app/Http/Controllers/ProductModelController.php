<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($productid)
    {
        $product = DB::select('select * from products where id = ?', [$productid])[0];
        $models = DB::select('
            select m.*, p.name
            from product_models m
            join products p on m.product_id = p.id
            where p.id = ?', [$productid]);
        return view('admin.product.model.index', ['models' => $models, 'product' => $product]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($productid)
    {
        $product = DB::selectOne('select * from products where id = ?', [$productid]);
        return view('admin.product.model.create', ['product' => $product]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $productid)
    {
        $request->validate([
            'size' => 'required|string',
            'color' => 'required|string',
            'price' => 'required|numeric'
        ]);

        DB::insert('insert into product_models(product_id, size, color, price) values(:product_id, :size, :color, :price)', [
            'product_id' => $productid,
            'size' => $request->input('size'),
            'color' => $request->input('color'),
            'price' => $request->input('price')
        ]);

        return redirect(route('admin.product.model.index', $productid));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($productid, $id)
    {
        $product = DB::selectOne('select * from products where id = ?', [$productid]);
        $model = DB::selectOne('select * from product_models where id = ?', [$id]);
        return view('admin.product.model.show', ['product' => $product, 'model' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($productid, $id)
    {
        $product = DB::selectOne('select * from products where id = ?', [$productid]);
        $model = DB::selectOne('select * from product_models where id = ?', [$id]);
        return view('admin.product.model.edit', ['product' => $product, 'model' => $model]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $productid, $id)
    {
        $request->validate([
            'size' => 'required|string',
            'color' => 'required|string',
            'price' => 'required|numeric'
        ]);

        DB::update('update product_models set size = :size, color = :color, price = :price where id = :id', [
            'size' => $request->input('size'),
            'color' => $request->input('color'),
            'price' => $request->input('price'),
            'id' => $id
        ]);

        return redirect(route('admin.product.model.index', $productid));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($productid, $id)
    {
        DB::delete('delete from product_models where id = ?', [$id]);
        return redirect(route('admin.product.model.index', $productid));
    }
}
