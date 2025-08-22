<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'username' => 'testuser',
        'name' => 'Test User',
        'email' => 'test@gmail.com', // dont use disposable email
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('admin.dashboard', absolute: false));
});
