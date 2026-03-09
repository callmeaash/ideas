<x-layout>
    <div>
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">Ideas</h1>
            <p class="text-sm text-muted-foreground mt-2">Capture your thoughts. Make a plan.</p>
        </header>

        <x-idea.card
            x-data
            @click="$dispatch('open-model', 'create-idea')"
            as="button"
            type="button"
            data-test="create-idea-btn"
            class="cursor-pointer h-26 w-full text-left"
        >
            What's the idea?
        </x-idea.card>

        <div class="mt-10">
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

                        @if ($idea->image)
                            <div class=" -mx-4 -mt-4 mb-4 h-64 rounded-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $idea->image) }}" alt="{{ $idea->title }}" class="w-full h-full object-cover">
                            </div>
                        @endif  

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

    <x-idea.modal />

</x-layout>