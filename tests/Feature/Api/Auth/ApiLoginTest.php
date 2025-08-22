<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

uses(RefreshDatabase::class);

describe('API Login Controller', function () {
    beforeEach(function () {
        // Clear rate limiter before each test
        RateLimiter::clear('login-test@gmail.com|127.0.0.1');
    });

    test('user can login successfully with email', function () {
        $user = User::factory()->create([
            'email' => 'test@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'id_user' => 'test@gmail.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'token',
                'token_type',
                'redirect',
                'data' => [
                    'id',
                    'name',
                    'username',
                    'email',
                    'role',
                    'email_verified_at',
                    'profile_photo_path',
                ]
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Logged in',
                'token_type' => 'Bearer',
            ]);

        expect($response->json('token'))->not()->toBeEmpty();
        expect($response->json('data.email'))->toBe('test@gmail.com');
    });

    test('user can login successfully with username', function () {
        $user = User::factory()->create([
            'username' => 'testuser',
            'email' => 'test@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'id_user' => 'testuser',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Logged in',
                'token_type' => 'Bearer',
            ]);

        expect($response->json('token'))->not()->toBeEmpty();
        expect($response->json('data.username'))->toBe('testuser');
    });

    test('login fails with invalid email credentials', function () {
        $user = User::factory()->create([
            'email' => 'test@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'id_user' => 'test@gmail.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
            ]);

        expect($response->json('message'))->toContain('credentials');
    });

    test('login fails with invalid username credentials', function () {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'id_user' => 'testuser',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
            ]);
    });

    test('login fails with non-existent user', function () {
        $response = $this->postJson('/api/auth/login', [
            'id_user' => 'nonexistent@gmail.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
            ]);
    });

    test('login requires id_user field', function () {
        $response = $this->postJson('/api/auth/login', [
            'password' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['id_user']);
    });

    test('login requires password field', function () {
        $response = $this->postJson('/api/auth/login', [
            'id_user' => 'test@gmail.com',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    });

    test('login accepts remember parameter', function () {
        $user = User::factory()->create([
            'email' => 'test@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'id_user' => 'test@gmail.com',
            'password' => 'password123',
            'remember' => true,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Logged in',
            ]);
    });

    test('login accepts redirect parameter', function () {
        $user = User::factory()->create([
            'email' => 'test@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'id_user' => 'test@gmail.com',
            'password' => 'password123',
            'redirect' => '/dashboard',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'redirect' => '/dashboard',
            ]);
    });

    test('successful login deletes existing tokens and creates new one', function () {
        $user = User::factory()->create([
            'email' => 'test@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        // Create an existing token
        $existingToken = $user->createToken('old-token');
        expect($user->tokens()->count())->toBe(1);

        $response = $this->postJson('/api/auth/login', [
            'id_user' => 'test@gmail.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);

        // Should still have only 1 token (old one deleted, new one created)
        expect($user->fresh()->tokens()->count())->toBe(1);

        // The token should be different
        expect($user->fresh()->tokens()->first()->name)->toBe('authToken');
    });

    test('login response includes correct user resource structure', function () {
        $user = User::factory()->create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@gmail.com',
            'role' => 'user',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'id_user' => 'test@gmail.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => 'Test User',
                    'username' => 'testuser',
                    'email' => 'test@gmail.com',
                    'role' => 'user',
                ]
            ]);

        // Ensure password is not included in response
        expect($response->json('data'))->not()->toHaveKey('password');
    });

    test('login with empty strings fails validation', function () {
        $response = $this->postJson('/api/auth/login', [
            'id_user' => '',
            'password' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['id_user', 'password']);
    });

    test('login handles case sensitivity correctly', function () {
        $user = User::factory()->create([
            'email' => 'test@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        // Email case should work as stored
        $response = $this->postJson('/api/auth/login', [
            'id_user' => 'test@gmail.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    });

    test('login response format is consistent', function () {
        $user = User::factory()->create([
            'email' => 'test@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'id_user' => 'test@gmail.com',
            'password' => 'password123',
        ]);

        $responseData = $response->json();

        expect($responseData)->toHaveKeys([
            'success',
            'message',
            'token',
            'token_type',
            'redirect',
            'data'
        ]);

        expect($responseData['success'])->toBeBool();
        expect($responseData['message'])->toBeString();
        expect($responseData['token'])->toBeString();
        expect($responseData['token_type'])->toBe('Bearer');
        expect($responseData['redirect'])->toBeString();
        expect($responseData['data'])->toBeArray();
    });
});
