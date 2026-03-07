<?php
use App\Models\Idea;
use App\Models\User;

it('checks authentication', function () {
    $idea = Idea::factory()->create();

    $this->get(route('idea.show', $idea->id))->assertRedirectToRoute('login');
});


it('checks authorization', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $idea = Idea::factory()->create();

    $this->get(route('idea.show', $idea->id))->assertForbidden();
    
});