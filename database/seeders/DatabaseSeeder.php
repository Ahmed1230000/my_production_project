<?php

namespace Database\Seeders;

use App\Domains\User\Database\Seeders\RoleAndPermissionSeeder;
use App\Domains\User\Database\Seeders\UserSeeder;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RoleAndPermissionSeeder::class,
        ]);
    }
}
