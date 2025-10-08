<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RoleCheckMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        if (! Route::has('test.superadmin')) {
            Route::middleware(['web', 'auth', 'role:superadmin'])
                ->get('/test-superadmin', fn () => response()->noContent())
                ->name('test.superadmin');
        }
    }

    public function test_superadmin_can_access_protected_route(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::SuperAdmin->value,
        ]);

        $response = $this->actingAs($user)->get(route('test.superadmin'));

        $response->assertNoContent();
    }

    public function test_non_superadmin_is_forbidden(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::User->value,
        ]);

        $response = $this->actingAs($user)->get(route('test.superadmin'));

        $response->assertForbidden();
    }
}
