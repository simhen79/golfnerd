<?php

namespace Database\Seeders;

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
            GolfClubTableSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Henry Sim',
            'email' => 'henry@simit.co.za',
        ]);
    }
}
