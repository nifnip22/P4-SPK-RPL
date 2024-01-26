<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'AdminPicopick',
            'email' => 'adminPicopick1@gmail.com',
            'password' => Hash::make('super.admin@picopick.id'),
            'level' => 'Admin',
        ]);
    }
}
