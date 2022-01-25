<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        User::create([
            'id_profile'        => 1,
            'first_name'        => 'Ignacio',
            'second_name'       => 'Manuel',
            'first_last_name'   => 'Sánchez',
            'second_last_name'  => 'Neri',
            'email'             => 'manuh0989@gmail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
        ])->assignRole('super.user.master');

        User::create([
            'id_profile'        => 1,
            'first_name'        => 'Laura',
            'second_name'       => null,
            'first_last_name'   => 'Hernandez',
            'second_last_name'  => 'Hernandez',
            'email'             => 'lhernandez@gmail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
        ])->assignRole('super.user.senior');

    }
}
