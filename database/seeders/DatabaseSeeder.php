<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GolfClubTableSeeder::class,
            UsersTableSeeder::class,
            ShieldSeeder::class,
        ]);

        Artisan::call('shield:super-admin --user=1 --panel=admin');
        Artisan::call('shield:generate --all --option=policies_and_permissions --panel=admin');
        Artisan::call('shield:generate --all --option=policies_and_permissions --panel=user');

    }
}
