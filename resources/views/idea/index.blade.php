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

    <x-modal name="create-idea" title="New Idea">
        
        <form
            x-data="{
                'status': 'pending',
                'newLink': '',
                'links': [],
                }"
            action="{{ route('idea.store') }}"
            method="POST"
            class="space-y-4 mt-5"
        >
            @csrf
            <x-form.field
                name="title"
                label="Title"
                placeholder="Enter a title for your Idea"
                autofocus
            />

            <div>
                <label for="status" class="label">Status</label>
                
                <div class="flex gap-x-3 mt-2">
                    @foreach (App\IdeaStatus::cases() as $status)
                        <button type="button" @click="status= @js($status->value)" :class="status === @js($status->value) ? 'btn' : 'btn btn-outlined'">
                            {{ $status->label() }}
                        </button>
                    @endforeach
                </div>

                <input type="hidden" name="status" :value="status">
            </div>

            <x-form.error name="status"/>

            <x-form.field 
                name="description"
                label="Description"
                type="textarea"
                placeholder="Describe your idea....."
            />

            <div class="space-y-3">
                <label for="" class="label">Links</label>

                <template x-for="(link, index) in links">
                    <div class="flex gap-x-2">
                        <input type="text" name="links[]" x-model="link" class="input flex-1">

                        <button
                            type="button"
                            @click="links.splice(index, 1)">
                            <x-icons.cross class="text-red-500"/>
                        </button>
                    </div>
                </template>


                <div class="flex gap-x-2">
                    <input
                        type="url"
                        x-model="newLink"
                        data-test="new-link"
                        placeholder="https://example.com"
                        autocomplete="url"
                        class="input flex-1"
                    >
                    <button 
                        type="button"
                        data-test="add-link-btn"
                        @click="links.push(newLink.trim()); newLink=''"
                        :disabled="!newLink"
                    >
                        <x-icons.plus />
                    </button>
                </div>
            </div>

            <div class="flex justify-end gap-x-3">
                <button type="reset" @click="show=false" class="btn btn-outlined">Cancel</button>
                <button type="submit" class="btn" data-test="create-idea-submit">Create</button>
            </div>
        </form>
    
    </x-modal>


    
</x-layout>