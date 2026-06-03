<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@guestbook.com',
            'password' => '123123123',
            'role_id' => 1
        ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@guestbook.com',
            'password' => '123123123',
            'role_id' => 2
        ]);
    }
}