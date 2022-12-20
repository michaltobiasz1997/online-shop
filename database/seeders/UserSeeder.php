<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory()->count(1)
            ->create([
                'email' => 'admin@gmail.com',
            ])
            ->each(function (User $user) {
                $user->assignRole('admin');
            });

        User::factory()->count(3)
            ->create()
            ->each(function (User $user) {
                $user->assignRole('customer');
            });
    }
}
