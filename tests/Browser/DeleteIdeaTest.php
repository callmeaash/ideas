<?php

use App\Models\Idea;
use App\Models\User;

it('deletes an idea', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    visit(route('idea.show', $idea->id))
        ->click('Delete')
        ->assertPathIs('/ideas');

    expect(Idea::count())->toBe(0);
});
