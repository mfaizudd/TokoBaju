<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->hasCustomerAddresses(3)
            ->create([
                'name' => 'Mega Admind',
                'phone' => '089643414876',
                'email' => 'admind@admin.com',
                'password' => Hash::make('password'),
                'role' => 'Admin'
            ]);

        User::factory()
            ->hasCustomerAddresses(3)
            ->create([
                'name' => 'Filthy Customer',
                'phone' => '085225751050',
                'email' => 'customer@filthy.com',
                'password' => Hash::make('password'),
                'role' => 'Customer'
            ]);
        User::factory()
                ->times(50)
                ->hasCustomerAddresses(3)
                ->create();
    }
}
