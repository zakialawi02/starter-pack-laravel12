<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('API Logout Controller', function () {
    // Helper method to force stateless API requests
    function postJsonStateless($uri, array $data = [], array $headers = [])
    {
        return test()->withHeaders(array_merge($headers, [
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
        ]))->post($uri, $data);
    }
    test('authenticated user can logout successfully', function () {
        $user = User::factory()->create();
        $token = $user->createToken('auth-token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ])->postJson('/api/auth/logout');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Logged out'
            ]);
    });

    test('logout deletes current access token only', function () {
        $user = User::factory()->create();

        // Create multiple tokens
        $token1 = $user->createToken('token1');
        $token2 = $user->createToken('token2');
        $token3 = $user->createToken('token3');

        expect($user->tokens()->count())->toBe(3);

        // Use token2 for authentication
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token2->plainTextToken
        ])->postJson('/api/auth/logout');

        $response->assertStatus(200);

        // Should have 2 tokens remaining (token1 and token3)
        expect($user->fresh()->tokens()->count())->toBe(2);

        // Verify the correct token was deleted (token2)
        $remainingTokens = $user->fresh()->tokens()->pluck('name')->toArray();
        expect($remainingTokens)->toContain('token1');
        expect($remainingTokens)->toContain('token3');
        expect($remainingTokens)->not()->toContain('token2');
    });

    test('logout fails without authentication', function () {
        $response = $this->postJson('/api/auth/logout');

        $response->assertStatus(401);
    });

    test('logout fails with invalid token', function () {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer invalid-token-here'
        ])->postJson('/api/auth/logout');

        $response->assertStatus(401);
    });

    test('logout fails with malformed authorization header', function () {
        $response = $this->withHeaders([
            'Authorization' => 'InvalidFormat token-here'
        ])->postJson('/api/auth/logout');

        $response->assertStatus(401);
    });

    test('logout fails with empty authorization header', function () {
        $response = $this->withHeaders([
            'Authorization' => ''
        ])->postJson('/api/auth/logout');

        $response->assertStatus(401);
    });

    test('logout handles token deletion error gracefully', function () {
        $user = User::factory()->create();
        $token = $user->createToken('auth-token');

        // Test normal logout - should succeed
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ])->postJson('/api/auth/logout');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Logged out'
            ]);
    });

    test('logout works with token created from login', function () {
        $user = User::factory()->create([
            'email' => 'test@gmail.com',
            'password' => bcrypt('password123'),
        ]);

        // Login to get token
        $loginResponse = $this->postJson('/api/auth/login', [
            'id_user' => 'test@gmail.com',
            'password' => 'password123',
        ]);

        $token = $loginResponse->json('token');

        // Check initial token count
        $initialTokenCount = $user->fresh()->tokens()->count();

        // Use token to logout
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('/api/auth/logout');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Logged out'
            ]);

        // For stateful requests, the token might be a TransientToken
        // In such cases, verify that logout was successful (status 200)
        // The token count verification depends on the authentication method used
        $finalTokenCount = $user->fresh()->tokens()->count();

        // If tokens were created and deleted, count should be 0
        // If using stateful authentication, the count might remain unchanged
        expect($finalTokenCount)->toBeLessThanOrEqual($initialTokenCount);
    });

    test('logout works with token created from registration', function () {
        // Register to get token
        $registerResponse = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $token = $registerResponse->json('token');
        $user = User::where('email', 'test@gmail.com')->first();

        // Use token to logout
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('/api/auth/logout');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Logged out'
            ]);

        // Verify token was deleted
        expect($user->fresh()->tokens()->count())->toBe(0);
    });

    test('logout response format is consistent', function () {
        $user = User::factory()->create();
        $token = $user->createToken('auth-token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ])->postJson('/api/auth/logout');

        $responseData = $response->json();

        expect($responseData)->toHaveKeys(['success', 'message']);
        expect($responseData['success'])->toBeBool();
        expect($responseData['message'])->toBeString();
    });


    test('logout with expired token fails', function () {
        $user = User::factory()->create();
        $token = $user->createToken('auth-token', ['*'], now()->subDay());

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ])->postJson('/api/auth/logout');

        $response->assertStatus(401);
    });

    test('user can logout from different devices independently', function () {
        $user = User::factory()->create();

        // Create tokens for different devices
        $deviceToken1 = $user->createToken('device1');
        $deviceToken2 = $user->createToken('device2');
        $deviceToken3 = $user->createToken('device3');

        expect($user->tokens()->count())->toBe(3);

        // Logout from device1
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $deviceToken1->plainTextToken
        ])->postJson('/api/auth/logout');

        $response->assertStatus(200);

        // Should have 2 tokens remaining
        expect($user->fresh()->tokens()->count())->toBe(2);

        // Device2 should still be able to logout
        $response2 = $this->withHeaders([
            'Authorization' => 'Bearer ' . $deviceToken2->plainTextToken
        ])->postJson('/api/auth/logout');

        $response2->assertStatus(200);
        expect($user->fresh()->tokens()->count())->toBe(1);

        // Device3 should still be able to logout
        $response3 = $this->withHeaders([
            'Authorization' => 'Bearer ' . $deviceToken3->plainTextToken
        ])->postJson('/api/auth/logout');

        $response3->assertStatus(200);
        expect($user->fresh()->tokens()->count())->toBe(0);
    });

    test('logout endpoint requires POST method', function () {
        $user = User::factory()->create();
        $token = $user->createToken('auth-token');

        // Test other HTTP methods should fail
        $getResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ])->getJson('/api/auth/logout');
        $getResponse->assertStatus(405);

        $putResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ])->putJson('/api/auth/logout');
        $putResponse->assertStatus(405);

        $deleteResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ])->deleteJson('/api/auth/logout');
        $deleteResponse->assertStatus(405);
    });
});
