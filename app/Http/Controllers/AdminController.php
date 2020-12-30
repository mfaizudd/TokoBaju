<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $products = DB::select('select * from products');
        $users = DB::select('select * from users');
        $categories = DB::select('select * from categories');
        return view('admin.dashboard', [
            'products' => $products,
            'users' => $users,
            'categories' => $categories
        ]);
    }
}
