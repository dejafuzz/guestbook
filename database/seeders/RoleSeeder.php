<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['name' => 'superadmin', 'label' => 'Super Admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'admin', 'label' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'client', 'label' => 'Client', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}