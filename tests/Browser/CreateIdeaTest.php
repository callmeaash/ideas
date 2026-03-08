<?php

use App\Models\Idea;
use App\Models\User;

it('create an idea', function () {
    $this->actingAs(User::factory()->create());

    visit('/ideas')
        ->click('@create-idea-btn')
        ->fill('@idea-title', 'Test Idea')
        ->fill('@idea-description', 'Test Description')
        ->fill('@new-link', 'https://example.com')
        ->click('@add-link-btn')
        ->click('@create-idea-submit')
        ->assertPathIs('/ideas');

    expect(Idea::count())->toBe(1);
    expect(Idea::first()->title)->toBe('Test Idea');
    expect(Idea::first()->links->toArray())->toBe(['https://example.com']);
});

it('fail to create idea', function () {
    $this->actingAs(User::factory()->create());
    visit('/ideas')
        ->click('@create-idea-btn')
        ->click('@create-idea-submit')
        ->assertPathIs('/ideas');

    expect(Idea::count())->toBe(0);
});

