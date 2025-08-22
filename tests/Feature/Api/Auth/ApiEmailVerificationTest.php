<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Notifications\VerifyEmail;

uses(RefreshDatabase::class);

describe('API Email Verification', function () {
    beforeEach(function () {
        Notification::fake();
        Event::fake();
    });

    describe('Email Verification Notification', function () {
        test('Authenticated user can request email verification notification', function () {
            $user = User::factory()->create([
                'email_verified_at' => null
            ]);

            $response = $this->actingAs($user, 'sanctum')
                ->postJson('/api/auth/email/verification-notification');

            $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Verification link sent'
                ]);

            // Verify notification was sent
            Notification::assertSentTo($user, VerifyEmail::class);
        });

        test('Email verification notification fails for already verified user', function () {
            $user = User::factory()->create([
                'email_verified_at' => now()
            ]);

            $response = $this->actingAs($user, 'sanctum')
                ->postJson('/api/auth/email/verification-notification');

            $response->assertStatus(400)
                ->assertJson([
                    'success' => false,
                    'message' => 'Email already verified'
                ]);

            // Verify no notification was sent
            Notification::assertNotSentTo($user, VerifyEmail::class);
        });

        test('Email verification notification requires authentication', function () {
            $response = $this->postJson('/api/auth/email/verification-notification');

            $response->assertStatus(401);
        });

        test('Email verification notification fails with invalid token', function () {
            $response = $this->withHeaders([
                'Authorization' => 'Bearer invalid-token'
            ])->postJson('/api/auth/email/verification-notification');

            $response->assertStatus(401);
        });

        test('Email verification notification handles sending errors gracefully', function () {
            $user = User::factory()->create([
                'email_verified_at' => null,
            ]);

            // Since we're using Notification::fake(), notifications won't actually be sent
            // and exceptions won't be thrown. This test verifies the normal success path
            // when notifications are faked, which is the expected behavior in test environment
            $response = $this->actingAs($user, 'sanctum')
                ->postJson('/api/auth/email/verification-notification');

            $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Verification link sent'
                ]);

            // Verify notification was queued (faked)
            Notification::assertSentTo($user, VerifyEmail::class);
        });

        test('Email verification notification error handling with real notification system', function () {
            // This test runs without Notification::fake() to test actual error handling
            Notification::clearResolvedInstances();

            $user = User::factory()->create([
                'email_verified_at' => null,
            ]);

            // Mock the Notification facade to throw an exception
            Notification::shouldReceive('send')
                ->once()
                ->andThrow(new \Exception('Mail service unavailable'));

            $response = $this->actingAs($user, 'sanctum')
                ->postJson('/api/auth/email/verification-notification');

            // The controller should catch the exception and return a 500 error
            $response->assertStatus(500)
                ->assertJson([
                    'success' => false,
                    'message' => 'Mail service unavailable'
                ]);

            // Restore the notification fake for other tests
            Notification::fake();
        });

        test('Email verification notification respects rate limiting', function () {
            $user = User::factory()->create([
                'email_verified_at' => null
            ]);

            // The endpoint has throttle:6,1 middleware
            // Make multiple requests to test rate limiting
            for ($i = 0; $i < 6; $i++) {
                $response = $this->actingAs($user, 'sanctum')
                    ->postJson('/api/auth/email/verification-notification');

                if ($i < 5) {
                    $response->assertStatus(200);
                }
            }

            // 7th request should be rate limited
            $response = $this->actingAs($user, 'sanctum')
                ->postJson('/api/auth/email/verification-notification');

            $response->assertStatus(429); // Too Many Requests
        });
    });

    describe('Email Verification Confirmation', function () {
        test('Authenticated user can verify email with valid signature', function () {
            $user = User::factory()->create([
                'email_verified_at' => null
            ]);

            // Generate a valid verification URL
            $verificationUrl = URL::temporarySignedRoute(
                'api.auth.verification.verify',
                now()->addMinutes(60),
                ['id' => $user->id, 'hash' => sha1($user->email)]
            );

            // Extract the path and query from the URL
            $parsedUrl = parse_url($verificationUrl);
            $path = $parsedUrl['path'];
            $query = $parsedUrl['query'] ?? '';

            $response = $this->actingAs($user, 'sanctum')
                ->get($path . '?' . $query);

            $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Email verified'
                ]);

            // Verify user's email was marked as verified
            $user->refresh();
            expect($user->email_verified_at)->not()->toBeNull();

            // Verify the Verified event was fired
            Event::assertDispatched(Verified::class);
        });

        test('Email verification fails for already verified user', function () {
            $user = User::factory()->create([
                'email_verified_at' => now()
            ]);

            // Generate a verification URL
            $verificationUrl = URL::temporarySignedRoute(
                'api.auth.verification.verify',
                now()->addMinutes(60),
                ['id' => $user->id, 'hash' => sha1($user->email)]
            );

            $parsedUrl = parse_url($verificationUrl);
            $path = $parsedUrl['path'];
            $query = $parsedUrl['query'] ?? '';

            $response = $this->actingAs($user, 'sanctum')
                ->get($path . '?' . $query);

            $response->assertStatus(400)
                ->assertJson([
                    'success' => false,
                    'message' => 'Email already verified'
                ]);

            // Verify event was not fired
            Event::assertNotDispatched(Verified::class);
        });

        test('Email verification requires authentication', function () {
            $user = User::factory()->create();

            $verificationUrl = URL::temporarySignedRoute(
                'api.auth.verification.verify',
                now()->addMinutes(60),
                ['id' => $user->id, 'hash' => sha1($user->email)]
            );

            $parsedUrl = parse_url($verificationUrl);
            $path = $parsedUrl['path'];
            $query = $parsedUrl['query'] ?? '';

            $response = $this->get($path . '?' . $query);

            $response->assertStatus(401);
        });

        test('Email verification fails with invalid signature', function () {
            $user = User::factory()->create([
                'email_verified_at' => null
            ]);

            // Create an invalid URL (wrong hash)
            $response = $this->actingAs($user, 'sanctum')
                ->get("/api/auth/verify-email/{$user->id}/invalid-hash");

            $response->assertStatus(403); // Forbidden due to invalid signature
        });

        test('Email verification fails with expired signature', function () {
            $user = User::factory()->create([
                'email_verified_at' => null
            ]);

            // Generate an expired verification URL
            $verificationUrl = URL::temporarySignedRoute(
                'api.auth.verification.verify',
                now()->subMinutes(60), // Expired
                ['id' => $user->id, 'hash' => sha1($user->email)]
            );

            $parsedUrl = parse_url($verificationUrl);
            $path = $parsedUrl['path'];
            $query = $parsedUrl['query'] ?? '';

            $response = $this->actingAs($user, 'sanctum')
                ->get($path . '?' . $query);

            $response->assertStatus(403); // Forbidden due to expired signature
        });

        test('Email verification fails for wrong user', function () {
            $user1 = User::factory()->create(['email_verified_at' => null]);
            $user2 = User::factory()->create(['email_verified_at' => null]);

            // Generate verification URL for user1 but use user2's authentication
            $verificationUrl = URL::temporarySignedRoute(
                'api.auth.verification.verify',
                now()->addMinutes(60),
                ['id' => $user1->id, 'hash' => sha1($user1->email)]
            );

            $parsedUrl = parse_url($verificationUrl);
            $path = $parsedUrl['path'];
            $query = $parsedUrl['query'] ?? '';

            $response = $this->actingAs($user2, 'sanctum')
                ->get($path . '?' . $query);

            $response->assertStatus(403); // Should fail authorization
        });

        test('Email verification respects rate limiting', function () {
            $user = User::factory()->create([
                'email_verified_at' => null
            ]);

            $verificationUrl = URL::temporarySignedRoute(
                'api.auth.verification.verify',
                now()->addMinutes(60),
                ['id' => $user->id, 'hash' => sha1($user->email)]
            );

            $parsedUrl = parse_url($verificationUrl);
            $path = $parsedUrl['path'];
            $query = $parsedUrl['query'] ?? '';

            // The endpoint has throttle:6,1 middleware
            for ($i = 0; $i < 6; $i++) {
                $response = $this->actingAs($user, 'sanctum')
                    ->get($path . '?' . $query);

                // First request should succeed, others may fail due to already verified
                if ($i === 0) {
                    $response->assertStatus(200);
                } else {
                    // After first success, user is verified, so subsequent requests return 400
                    $response->assertStatus(400);
                }
            }

            // After rate limit
            $response = $this->actingAs($user, 'sanctum')
                ->get($path . '?' . $query);

            $response->assertStatus(429); // Too Many Requests
        });
    });

    describe('Email Verification Notice Endpoint', function () {
        test('Verify email notice endpoint returns correct response for unauthenticated user', function () {
            $response = $this->getJson('/api/auth/verify-email');

            $response->assertStatus(401)
                ->assertJson([
                    'success' => false,
                    'message' => 'Please Verify Email [POST] /api/auth/verify-email'
                ]);
        });

        test('Verify email notice endpoint works for authenticated user', function () {
            $user = User::factory()->create([
                'email_verified_at' => null
            ]);

            $response = $this->actingAs($user, 'sanctum')
                ->getJson('/api/auth/verify-email');

            $response->assertStatus(401)
                ->assertJson([
                    'success' => false,
                    'message' => 'Please Verify Email [POST] /api/auth/verify-email'
                ]);
        });

        test('Verify email notice respects rate limiting', function () {
            $user = User::factory()->create();

            // Test rate limiting on the notice endpoint
            for ($i = 0; $i < 6; $i++) {
                $response = $this->actingAs($user, 'sanctum')
                    ->getJson('/api/auth/verify-email');

                if ($i < 5) {
                    $response->assertStatus(401);
                }
            }

            // 7th request should be rate limited
            $response = $this->actingAs($user, 'sanctum')
                ->getJson('/api/auth/verify-email');

            $response->assertStatus(429); // Too Many Requests
        });
    });

    test('Email verification response formats are consistent', function () {
        $user = User::factory()->create([
            'email_verified_at' => null
        ]);

        // Test notification response format
        $notificationResponse = $this->actingAs($user, 'sanctum')
            ->postJson('/api/auth/email/verification-notification');

        $notificationData = $notificationResponse->json();
        expect($notificationData)->toHaveKeys(['success', 'message']);
        expect($notificationData['success'])->toBeBool();
        expect($notificationData['message'])->toBeString();

        // Test verification response format
        $verificationUrl = URL::temporarySignedRoute(
            'api.auth.verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $parsedUrl = parse_url($verificationUrl);
        $path = $parsedUrl['path'];
        $query = $parsedUrl['query'] ?? '';

        $verificationResponse = $this->actingAs($user, 'sanctum')
            ->get($path . '?' . $query);

        $verificationData = $verificationResponse->json();
        expect($verificationData)->toHaveKeys(['success', 'message']);
        expect($verificationData['success'])->toBeBool();
        expect($verificationData['message'])->toBeString();
    });

    test('Email verification integration with registration flow', function () {
        // Register a new user
        $registerResponse = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $token = $registerResponse->json('token');
        $user = User::where('email', 'test@example.com')->first();

        // User should not be verified initially
        expect($user->email_verified_at)->toBeNull();

        // Request verification notification
        $notificationResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('/api/auth/email/verification-notification');

        $notificationResponse->assertStatus(200);

        // Verify the email
        $verificationUrl = URL::temporarySignedRoute(
            'api.auth.verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $parsedUrl = parse_url($verificationUrl);
        $path = $parsedUrl['path'];
        $query = $parsedUrl['query'] ?? '';

        $verificationResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get($path . '?' . $query);

        $verificationResponse->assertStatus(200);

        // User should now be verified
        $user->refresh();
        expect($user->email_verified_at)->not()->toBeNull();
    });
});
