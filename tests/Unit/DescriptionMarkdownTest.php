<?php

use App\Models\Idea;

it('formats description with markdown', function () {
    $idea = new Idea(['description' => 'hello world']);

    expect((string) $idea->formatted_description)->toContain('<p>hello world</p>');
});
