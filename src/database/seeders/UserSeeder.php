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
        
        $user = User::create([
            'first_name'        => 'Ignacio',
            'second_name'       => 'Manuel',
            'first_last_name'   => 'Sánchez',
            'second_last_name'  => 'Neri',
            'email'             => 'manuh0989@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password'          => Hash::make('0989nacho'),
        ]);
        
        $user->assignRole('master');

    }
}
