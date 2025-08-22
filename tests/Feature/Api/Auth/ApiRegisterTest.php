<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

describe('API Register Controller', function () {
    beforeEach(function () {
        Event::fake();
    });

    test('user can register successfully', function () {
        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/auth/register', $userData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'token',
                'token_type',
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
                'message' => 'Registered successfully and logged in',
                'token_type' => 'Bearer',
            ]);

        expect($response->json('token'))->not()->toBeEmpty();
        expect($response->json('data.email'))->toBe('test@example.com');
        expect($response->json('data.username'))->toBe('testuser');
        expect($response->json('data.name'))->toBe('Test User');

        // Verify user was created in database
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'username' => 'testuser',
            'name' => 'Test User',
        ]);

        // Verify password was hashed
        $user = User::where('email', 'test@example.com')->first();
        expect(Hash::check('password123', $user->password))->toBeTrue();
    });

    test('registration fires registered event', function () {
        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $this->postJson('/api/auth/register', $userData);

        Event::assertDispatched(Registered::class);
    });

    test('registration creates access token automatically', function () {
        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/auth/register', $userData);

        $response->assertStatus(201);

        $user = User::where('email', 'test@example.com')->first();
        expect($user->tokens()->count())->toBe(1);
        expect($user->tokens()->first()->name)->toBe('authToken');
    });

    test('registration fails with missing name', function () {
        $userData = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/auth/register', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonValidationErrors(['name']);
    });

    test('registration fails with missing username', function () {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/auth/register', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonValidationErrors(['username']);
    });

    test('registration fails with missing email', function () {
        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/auth/register', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonValidationErrors(['email']);
    });

    test('registration fails with missing password', function () {
        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/auth/register', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonValidationErrors(['password']);
    });

    test('registration fails with password confirmation mismatch', function () {
        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different123',
        ];

        $response = $this->postJson('/api/auth/register', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonValidationErrors(['password']);
    });

    test('registration fails with duplicate email', function () {
        // Create existing user
        User::factory()->create(['email' => 'test@example.com']);

        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/auth/register', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonValidationErrors(['email']);
    });

    test('registration fails with duplicate username', function () {
        // Create existing user
        User::factory()->create(['username' => 'testuser']);

        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/auth/register', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonValidationErrors(['username']);
    });

    test('registration fails with invalid email format', function () {
        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/auth/register', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonValidationErrors(['email']);
    });

    test('registration fails with short password', function () {
        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => '123',
            'password_confirmation' => '123',
        ];

        $response = $this->postJson('/api/auth/register', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonValidationErrors(['password']);
    });

    test('registration fails with short username', function () {
        $userData = [
            'name' => 'Test User',
            'username' => 'ab',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/auth/register', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonValidationErrors(['username']);
    });

    test('registration fails with long name', function () {
        $userData = [
            'name' => str_repeat('a', 256), // 256 characters
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/auth/register', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonValidationErrors(['name']);
    });

    test('registration fails with long username', function () {
        $userData = [
            'name' => 'Test User',
            'username' => str_repeat('a', 256), // 256 characters
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/auth/register', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonValidationErrors(['username']);
    });

    test('registration fails with long email', function () {
        $longEmail = str_repeat('a', 250) . '@example.com'; // > 255 characters

        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => $longEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/auth/register', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonValidationErrors(['email']);
    });

    test('registration fails with username containing invalid characters', function () {
        $userData = [
            'name' => 'Test User',
            'username' => 'test user!', // spaces and special chars not allowed
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/auth/register', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonValidationErrors(['username']);
    });

    test('registration allows username with underscores and numbers', function () {
        $userData = [
            'name' => 'Test User',
            'username' => 'test_user_123',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/auth/register', $userData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('users', [
            'username' => 'test_user_123',
        ]);
    });

    test('registration response excludes password', function () {
        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/auth/register', $userData);

        $response->assertStatus(201);

        expect($response->json('data'))->not()->toHaveKey('password');
        expect($response->json('data'))->not()->toHaveKey('remember_token');
    });

    test('registration response format is consistent', function () {
        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/auth/register', $userData);

        $responseData = $response->json();

        expect($responseData)->toHaveKeys([
            'success',
            'message',
            'token',
            'token_type',
            'data'
        ]);

        expect($responseData['success'])->toBeBool();
        expect($responseData['message'])->toBeString();
        expect($responseData['token'])->toBeString();
        expect($responseData['token_type'])->toBe('Bearer');
        expect($responseData['data'])->toBeArray();
    });

    test('registration validation error response format is consistent', function () {
        $userData = [
            'name' => '',
            'username' => '',
            'email' => 'invalid-email',
            'password' => '123',
        ];

        $response = $this->postJson('/api/auth/register', $userData);

        $responseData = $response->json();

        expect($responseData)->toHaveKeys(['success', 'errors']);
        expect($responseData['success'])->toBeFalse();
        expect($responseData['errors'])->toBeArray();
    });
});
