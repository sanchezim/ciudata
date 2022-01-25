<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profiles  = [
            ['name' => 'Súper Usuario', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Administrador', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Funcionaro', 'created_at' => now(), 'updated_at' => now()]
        ];
        Profile::insert($profiles);
    }
}
