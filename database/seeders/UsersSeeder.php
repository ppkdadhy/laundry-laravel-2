<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // insert into users () VALUES('')
        // User::create([
        //     'id_level' => 1,
        //     'name'  => 'Admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('12345678')
        // ]);
        User::create([
            'id_level' => 2,
            'name'  => 'Operator',
            'email' => 'operator@gmail.com',
            'password' => Hash::make('12345678')
        ]);
    }
}
