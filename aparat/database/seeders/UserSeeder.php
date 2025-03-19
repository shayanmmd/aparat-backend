<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        User::create([
            'email' => 'www.shayanmehmandoost37@yahoo.com',
            'mobile' => '09012508847',
            'name' => 'shayan',
            'password' => Hash::make('371382dfdsfs'),
            'verify-at' => now()
        ]);
    }
}
