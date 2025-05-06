<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Crea los roles si no existen
         Role::firstOrCreate(['name' => 'administrador']);
         Role::firstOrCreate(['name' => 'vendedor']);
    }
}
