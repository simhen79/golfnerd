<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ShieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Installing Filament Shield...');

        Artisan::call('shield:install');

        $this->command->info('Shield installed successfully.');

        $this->command->info('Creating super admin user...');

        $user = User::firstOrCreate(
            ['email' => 'henry@simit.co.za'],
            [
                'name' => 'Henry Sim',
            ]
        );

        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);

        if (!$user->hasRole('super_admin')) {
            $user->assignRole($superAdminRole);
            $this->command->info('Super admin role assigned to henry@simit.co.za');
        } else {
            $this->command->info('User already has super_admin role');
        }

        $this->command->info('Setup complete!');
    }
}
