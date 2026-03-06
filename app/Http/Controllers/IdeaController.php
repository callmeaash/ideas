<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\IdeaStatus;
use App\Models\Idea;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $ideas = auth()->user()->ideas()
            ->when(request('status'), fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->get();

        return view('idea.index', [
            'ideas' => $ideas,
            'statusCounts' => Idea::statusCounts(auth()->user()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIdeaRequest $request): RedirectResponse
    {
        $idea = auth()->user()->ideas()->create($request->safe()->except('steps'));

        $idea->steps()->createMany(
            collect($request->safe()->steps ?? [])->map(fn($step) => ['description' => $step])
        );

        return redirect()->route('home')->with('success', 'Idea created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea): View
    {
        return view('idea.show', [
            'idea' => $idea,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Idea $idea): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea): void
    {
        //
    }
}
