<?php

namespace App\Domains\User\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        return User::createOrFirst([
            'name'              => 'admin',
            'email'             => 'admin@system.com',
            'email_verified_at' => now(),
            'status'            => 'active',
            'password'          => Hash::make('password'),
            'remember_token'    => Str::random(10),
        ]);
    }
}
