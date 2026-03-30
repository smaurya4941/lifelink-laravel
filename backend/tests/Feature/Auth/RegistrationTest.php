<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('onboarding.capabilities.edit', absolute: false));
    }

    public function test_hospital_can_register_via_separate_flow(): void
    {
        $response = $this->post('/register/hospital', [
            'name' => 'Hospital Admin',
            'email' => 'hospital@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'hospital_name' => 'City Care Hospital',
            'license_number' => 'LIC-12345',
            'address' => 'Main Road, Metro City',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('hospital.dashboard', absolute: false));
        $this->assertDatabaseHas('hospitals', [
            'hospital_name' => 'City Care Hospital',
            'license_number' => 'LIC-12345',
        ]);
    }
}
