<?php

use App\Models\User;
use App\Models\Idea;

it('create an idea', function () {
    $this->actingAs(User::factory()->create());

    visit('/ideas')
        ->click('@create-idea-btn')
        ->fill('title', 'Test Idea')
        ->fill('description', 'Test Description')
        ->click('@create-idea-submit')
        ->assertPathIs('/ideas');
    
    expect(Idea::first()->title)->toBe('Test Idea');
});

it('fail to create idea', function (){
    $this->actingAs(User::factory()->create());
    visit('/ideas')
        ->click('@create-idea-btn')
        ->click('@create-idea-submit')
        ->assertPathIs('/ideas');
    
    expect(Idea::count())->toBe(0);
});