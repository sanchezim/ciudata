<?php

namespace Database\Seeders;

use App\Models\Catalogs\CatModule;
use Illuminate\Database\Seeder;

class CatModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = [
            ['name' => 'Roles y permisos', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Administracion de usuarios', 'created_at' => now(), 'updated_at' => now()],
        ];
        CatModule::insert($modules);
    }
}
