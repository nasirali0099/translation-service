<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class TranslationTest extends TestCase
{
    use RefreshDatabase;

    private function authUser()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        return $user;
    }

    public function test_can_create_translation()
    {
        $this->authUser();

        $response = $this->postJson('/api/translations', [
            'key' => 'welcome',
            'values' => [
                ['locale' => 'en', 'value' => 'Hello'],
                ['locale' => 'fr', 'value' => 'Bonjour']
            ],
            'tags' => ['web']
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'key' => 'welcome'
            ]);
    }

    public function test_validation_fails_when_missing_key()
    {
        $this->authUser();

        $response = $this->postJson('/api/translations', [
            'values' => []
        ]);

        $response->assertStatus(422);
    }

    public function test_can_search_translation_by_key()
    {
        $this->authUser();

        $this->postJson('/api/translations', [
            'key' => 'checkout',
            'values' => [
                ['locale' => 'en', 'value' => 'Checkout']
            ],
            'tags' => ['web']
        ]);

        $response = $this->getJson('/api/translations?key=checkout');

        $response->assertStatus(200);
    }
}