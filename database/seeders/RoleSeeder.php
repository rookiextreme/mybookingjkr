<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Admin',
            'display_name' => 'Admin',
            'description' => 'Admin User'
        ]);

        DB::table('roles')->insert([
            'name' => 'Penyelaras',
            'display_name' => 'Penyelaras',
            'description' => 'Penyelaras User'
        ]);

        DB::table('roles')->insert([
            'name' => 'Penyelia',
            'display_name' => 'Penyelia',
            'description' => 'Penyelia User'
        ]);

        DB::table('roles')->insert([
            'name' => 'Pengguna',
            'display_name' => 'Pengguna',
            'description' => 'Pengguna User'
        ]);
    }
}
