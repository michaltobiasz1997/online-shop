<?php

namespace Tests;

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    public User $user;
    public User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesAndPermissionsSeeder::class);

        $this->withoutVite();

        $this->user = $this->createUser();
        $this->secondUser = $this->createUser();
        $this->admin = $this->createUser(isAdmin: true);
    }

    private function createUser(bool $isAdmin = false): User
    {
        $user = User::factory()->create();

        $user->assignRole($isAdmin ? 'admin' : 'customer');

        return $user;
    }
}
