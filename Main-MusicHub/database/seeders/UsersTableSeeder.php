<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->truncate();
        for ($i = 1; $i <= 5; $i++) {
            DB::table("users")->insert([
                'name' => 'user'. $i,
                'email'=> 'user' . $i . '@user.com',
                'email_verified_at' => now(),
                'password'=> Hash::make('user' . $i),
            ]);
        }
    }
}
