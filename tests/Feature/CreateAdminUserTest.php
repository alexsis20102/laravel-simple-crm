<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateAdminUserTest extends TestCase
{
    public function test_admin_user_can_be_created(): void
    {
        $password = 'admin';

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make($password)
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'admin@test.com'
        ]);

        $this->assertTrue(Hash::check($password, $admin->password));
    }
}
