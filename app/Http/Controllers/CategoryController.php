<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    const ROUTE_INDEX = "admin.category.index";
    const GET_CATEGORY_BY_ID = 'select * from categories where id = ?';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = DB::select('select * from categories');
        return view(CategoryController::ROUTE_INDEX, ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.category.create");
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
            'name' => 'required|string'
        ]);
        $success = DB::insert('insert into categories(name) values(?)', [$request->name]);
        if (!$success)
        {
            return view("admin.category.create");
        }
        return redirect(route(CategoryController::ROUTE_INDEX));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = DB::select(CategoryController::GET_CATEGORY_BY_ID, [ $id ]);
        return view("admin.category.show", ['category' => $category[0]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = DB::select(CategoryController::GET_CATEGORY_BY_ID, [ $id ]);
        return view("admin.category.edit", ['category' => $category[0]]);
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
            'name' => 'required|string'
        ]);
        $category = DB::select(CategoryController::GET_CATEGORY_BY_ID, [$id]);
        $success = DB::update('update categories set name = ? where id = ?', [$request->name, $id]);
        if (!$success)
        {
            return view("admin.category.edit", ['category'=>$category[0]]);
        }
        return redirect(route(CategoryController::ROUTE_INDEX));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from categories where id = ?', [$id]);
        return redirect(route(CategoryController::ROUTE_INDEX));
    }
}
