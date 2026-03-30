<?php

namespace Tests\Feature;

use App\Models\RecipientProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipientProfileVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_recipient_profile_snapshot_is_visible_on_requests_page(): void
    {
        $user = User::factory()->create([
            'role' => 'recipient',
            'is_recipient' => true,
            'is_donor' => false,
        ]);

        RecipientProfile::create([
            'user_id' => $user->id,
            'medical_condition' => 'None',
            'emergency_contact' => '9999999999',
            'blood_group' => 'A+',
            'age' => 25,
            'weight' => 60,
            'address' => 'Street 1',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
        ]);

        $response = $this->actingAs($user)->get(route('requests.index'));

        $response->assertStatus(200);
        $response->assertSee('Profile Snapshot');
        $response->assertSee('9999999999');
        $response->assertSee('Mumbai');
    }
}
