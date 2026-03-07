<?php

use App\Models\User;

it('logs in a user', function () {
    $user = User::factory()->create([
        'password' => '@JohnDoe123',
    ]);

    visit('/login')
        ->fill('email', $user->email)
        ->fill('password', '@JohnDoe123')
        ->click('@login-submit')
        ->assertPathIs('/ideas');

    $this->assertAuthenticated();

    expect(auth()->user()->email)->toBe($user->email);
});

it('logs out a user', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/')->click('Log Out')
        ->assertPathIs('/login');

    $this->assertGuest();
});
