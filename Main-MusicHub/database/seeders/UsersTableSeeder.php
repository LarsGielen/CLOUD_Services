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
        // Add a default admin user to the database
        DB::table("users")->truncate();
        DB::table("users")->insert([
            'name' => 'Admin',
            'email'=> 'admin@admin.com',
            'email_verified_at' => now(),
            'password'=> Hash::make('Admin'),
        ]);
    }
}
