<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    const ROUTE_INDEX = 'admin.user.index';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::select('select * from users');
        return view(UserController::ROUTE_INDEX, ['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'phone' => 'required|string|numeric|min:10',
            'role' => ['required', 'string', Rule::in(['Admin', 'Customer'])],
        ]);
        DB::transaction(function () use ($request) {
            DB::insert('insert into users(name, email, password, phone, role) values(:name, :email, :password, :phone, :role)', [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'phone' => $request->input('phone'),
                'role' => $request->input('role')
            ]);
            $id = DB::select('select last_insert_id() as id from users')[0]->id;

            $customerAddresses = [];
            foreach ($request->input('addresses', []) as $key => $value) {
                $phones = $request->input('phones', []);
                $customerAddresses[]['address'] = $value;
                $customerAddresses[$key]['phone'] = $phones[$key];
            }

            foreach ($customerAddresses as $value) {
                DB::insert('insert into customer_addresses(user_id, address, phone) values(?, ?, ?)', [$id, $value['address'], $value['phone']]);
            }
        });
        return redirect(route(UserController::ROUTE_INDEX));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = DB::select('select * from users where id = ?', [$id])[0];
        return view('admin.user.show', ['user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = DB::select('select * from users where id = ?', [$id])[0];
        $customerAddresses = DB::select('select * from customer_addresses where user_id = ?', [$id]);
        return view('admin.user.edit', ['user' => $user, 'customerAddresses' => $customerAddresses]);
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
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'phone' => 'required|string|numeric|min:10',
            'role' => ['required', 'string', Rule::in(['Admin', 'Customer'])],
        ]);
        DB::transaction(function () use ($request, $id) {
            DB::update('update users set name = :name, email = :email, phone = :phone, role = :role where id = :id', [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'role' => $request->input('role'),
                'id' => $id
            ]);

            DB::delete('delete from customer_addresses where user_id = ?', [$id]);

            $customerAddresses = [];
            foreach ($request->input('addresses', []) as $key => $value) {
                $phones = $request->input('phones', []);
                $customerAddresses[$key]['address'] = $value;
                $customerAddresses[$key]['phone'] = $phones[$key];
            }

            foreach ($customerAddresses as $value) {
                DB::insert('insert into customer_addresses(user_id, address, phone) values(?, ?, ?)', [$id, $value['address'], $value['phone']]);
            }
        });
        return redirect(route(UserController::ROUTE_INDEX));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from users where id = ?', [$id]);
        return redirect(route(UserController::ROUTE_INDEX));
    }
}
