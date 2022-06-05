<?php

namespace Database\Seeders;

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
    public function run(string $email, string $password)
    {
        DB::table('users')->insert([
            'email' => $email,
            'password' => Hash::make($password)
        ]);
    }
}
