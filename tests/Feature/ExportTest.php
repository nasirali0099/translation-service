<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class ExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_export_returns_json_structure()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/export');

        $response->assertStatus(200);
        $this->assertIsArray($response->json());
    }
}