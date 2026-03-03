<x-layout>
    <div>
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">Ideas</h1>
            <p class="text-sm text-muted-foreground mt-2">Capture your thoughts. Make a plan.</p>
        </header>

        <div>
            <a href="/" class="btn {{ request('status')? 'btn-outlined': '' }}">All <span class="text-xs pl-3">{{ $statusCounts['all'] }}</span></a>
    
            @foreach (App\IdeaStatus::cases() as $status)
                <a href="/ideas?status={{ $status->value }}" class="btn {{ request('status') === $status->value ? '': 'btn-outlined' }}">
                    {{ $status->label() }} <span class="text-xs pl-3">{{ $statusCounts[$status->value] }}</span>
                </a>
            @endforeach
        </div>


        <div class="mt-10 text-muted-foreground">
            <div class="grid md:grid-cols-2 gap-6">

                @forelse ($ideas as $idea)
                    <x-idea.card href="{{ route('idea.show', $idea->id) }}">
                        <h3 class="text-foreground text-lg">{{ $idea->title }}</h3>

                        <x-idea.status-label class="{{ $idea->status->color() }}">
                            {{ $idea->status->label() }}
                        </x-idea.status-label>

                        <div class="mt-5 line-clamp-5">{{ $idea->description }}</div>
                        <div class="mt-4">{{ $idea->created_at->diffForHumans() }}</div>
                    </x-idea.card>
                @empty

                    <p>No ideas yet.</p>

                @endforelse
            </div>
        </div>
    </div>
</x-layout>