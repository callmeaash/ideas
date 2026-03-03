<?php

it('registers a user', function () {
    visit('/register')
        ->fill('name', 'John Doe')
        ->fill('email', 'john@example.com')
        ->fill('password', '@JohnDoe123')
        ->fill('password_confirmation', '@JohnDoe123')
        ->submit()
        ->assertPathIs('/');

    $this->assertAuthenticated();

    expect(auth()->user()->email)->toBe('john@example.com');
});
