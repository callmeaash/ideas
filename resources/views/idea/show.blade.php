<x-layout>
    <div class="py-8 max-w-4xl mx-auto">

        <div class="flex justify-between">
            <a href="{{ route('home') }}" class="flex gap-x-2 items-center">
                <x-icons.arrow-back />
                Back to Ideas
            </a>

            <div class="flex gap-x-2 items-center">
                <button class="btn btn-outlined">
                    <x-icons.edit />
                    Edit Idea
                </button>
                
                <form action="{{ route('idea.destroy', $idea->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outlined text-red-500">Delete</button>
                </form>
            </div>
        </div>
        
        <div class="mt-8 space-y-6">
            <h1 class="text-4xl font-bold">{{ $idea->title }}</h1>

            <div class="mt-2 flex items-center gap-x-3">
                <x-idea.status-label class="{{ $idea->status->color() }}">
                    {{ $idea->status->label() }}
                </x-idea.status-label>

                <span class="text-muted-foreground">{{ $idea->created_at->diffForHumans() }}</span>
            </div>

            <x-idea.card class="mt-6">
                <p class="text-muted-foreground cursor-pointer max-w-none">{{ $idea->description }}</p>
            </x-idea.card>


            @if ($idea->steps->count())
                <div>
                    <h3 class="text-xl font-bold mt-6">Actionable Steps</h3>

                    <div class="mt-3 space-y-3">
                        @foreach ($idea->steps as $step)
                            <form action="{{ route('step.update', $step->id) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <x-idea.card class="flex items-center gap-x-3">
                                    <button type="submit" class="size-5 flex items-center justify-center rounded-lg text-primary-foreground border border-primary {{ $step->completed? 'bg-primary': '' }}">
                                        &check;
                                    </button>
                                    <span class="{{ $step->completed? 'line-through text-muted-foreground': '' }}">{{ $step->description }}</span>
                                </x-idea.card>
                            </form>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($idea->links->count())
                <div>
                    <h3 class="text-xl font-bold mt-6">Links</h3>

                    <div class="mt-3 space-y-3">
                        @foreach ($idea->links as $link)
                            <x-idea.card href="{{ $link }}" target="_blank" class="text-primary hover:underline flex items-center gap-x-3">
                                <x-icons.external />
                                {{ $link }}
                            </x-idea.card>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layout>