<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role' => 'owner',
            'username' => 'Owner_Name',
            'email' => 'ownername@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
