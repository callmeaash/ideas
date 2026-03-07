<?php

namespace App\Actions;

use App\Models\Idea;
use Illuminate\Support\Facades\Storage;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CreateIdea
{
    public function __construct(#[CurrentUser] protected User $user)
    {
        //
    }

    public function handle(array $attributes)
    {
        $data = collect($attributes)->only([
            'title', 'description', 'status', 'links'
        ])->toArray();


        if (isset($attributes['image'])) {
            $data['image'] = $attributes['image']->store('ideas', 'public');
        }

        DB::transaction(function () use ($data, $attributes) {
            $idea = $this->user->ideas()->create($data);

            $steps = collect($attributes['steps'] ?? [])->map(fn($step) => ['description' => $step]);
            
            $idea->steps()->createMany($steps);
        });
    }
}