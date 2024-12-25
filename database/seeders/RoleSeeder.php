<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role')->insert([
            ['idRole' => 1, 'nama_role' => 'Pengelola'],
            ['idRole' => 2, 'nama_role' => 'Penghuni'],
            ['idRole' => 3, 'nama_role' => 'ART'],
        ]);
    }
}
