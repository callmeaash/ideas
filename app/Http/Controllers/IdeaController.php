<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateIdea;
use App\Http\Requests\StoreIdeaRequest;
use App\Models\Idea;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

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
    public function store(StoreIdeaRequest $request, CreateIdea $action)
    {
        $action->handle($request->safe()->all());

        return redirect()->route('home')->with('success', 'Idea created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea): View
    {
        Gate::authorize('workWith', $idea);

        return view('idea.show', [
            'idea' => $idea,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreIdeaRequest $request, Idea $idea): RedirectResponse
    {
        Gate::authorize('workWith', $idea);

        if ($request->remove_image && $idea->image) {
            Storage::disk('public')->delete($idea->image);
            $idea->image = null;
        }

        if ($request->hasFile('image')) {
            if ($idea->image) {
                Storage::disk('public')->delete($idea->image);
            }
            $idea->image = $request->file('image')->store('ideas', 'public');
        }

        $idea->save();

        $idea->update($request->safe()->except('image'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        Gate::authorize('workWith', $idea);
        $idea->delete();

        return redirect()->route('home')->with('success', 'Idea deleted successfully!');
    }
}
