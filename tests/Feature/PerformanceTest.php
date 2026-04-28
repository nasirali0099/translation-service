<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class ExportPerformanceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that export endpoint responds within 500ms.
     */
    public function test_export_endpoint_performance()
    {
        // Arrange: create authenticated user
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        // Optional: seed minimal test data (important for real benchmark)
        // You can also use factories here if needed

        // Measure start time (high precision)
        $start = hrtime(true);

        // Act: call export endpoint
        $response = $this->getJson('/api/export');

        // Measure end time
        $durationMs = (hrtime(true) - $start) / 1_000_000;

        // Assert response is successful
        $response->assertStatus(200);

        // Assert performance requirement (< 500ms)
        $this->assertLessThan(
            500,
            $durationMs,
            "Export endpoint is too slow: {$durationMs}ms (must be < 500ms)"
        );
    }
}