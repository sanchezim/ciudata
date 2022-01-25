<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CatModuleSeeder::class,
            ProfileSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);

         User::factory(10)->create();
        
    }
}
