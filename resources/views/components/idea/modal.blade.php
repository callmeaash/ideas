@props(['idea' => new \App\Models\Idea()])

<x-modal
    name="{{ $idea->exists ? 'edit-idea' : 'create-idea' }}"
    title="{{ $idea->exists ? 'Edit Idea' : 'New Idea' }}"
>
    <form
        x-data="{
            status: @js($idea->status->value ?? 'pending'),
            newLink: '',
            links: @js(old('links', $idea->links ?? [])),
            newStep: '',
            steps: @js(old('steps', $idea->steps->pluck('description'))),
            originalImage: @js($idea->image),
            preview: @js($idea->image),
            removeImage: false,
            resetForm() {
                this.preview = this.originalImage;
                this.removeImage = false;
            }
        }"
        action="{{ $idea->exists ? route('idea.update', $idea) : route('idea.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-4 mt-5"
    >
        @csrf
        @if ($idea->exists)
            @method('PATCH')
        @endif
        <x-form.field
            name="title"
            label="Title"
            placeholder="Enter a title for your Idea"
            :value="$idea->title"
        />

        <div>
            <label class="label">Status</label>
            <div class="flex gap-x-3 mt-2">
                @foreach (App\IdeaStatus::cases() as $status)
                    <button
                        type="button"
                        @click="status=@js($status->value)"
                        :class="status === @js($status->value) ? 'btn' : 'btn btn-outlined'"
                    >
                        {{ $status->label() }}
                    </button>
                @endforeach
            </div>
            <input type="hidden" name="status" :value="status">
            <x-form.error name="status" />
        </div>

        <x-form.field
            name="description"
            label="Description"
            type="textarea"
            placeholder="Describe your idea..."
            :value="$idea->description"
        />

        <div class="space-y-3">
            <label class="label">Featured Image</label>

            <template x-if="preview">
                <div class="space-y-2">
                    <div class="rounded-lg overflow-hidden h-72">
                        <img :src="preview.startsWith('blob:') ? preview : '/storage/' + preview" class="w-full h-full object-cover">
                    </div>

                    <button
                        type="button"
                        @click="preview=null; removeImage=true"
                        class="bg-red-500 btn w-full rounded"
                    >
                        Remove Image
                    </button>
                </div>
            </template>

            <input
                type="file"
                name="image"
                accept="image/*"
                @change="
                    preview = URL.createObjectURL($event.target.files[0]);
                    removeImage=false;
                "
            >

            <input type="hidden" name="remove_image" :value="removeImage">
            <x-form.error name="image" />
        </div>

        <div class="space-y-3">
            <label class="label">Actionable Steps</label>

            <template x-for="(step, index) in steps">
                <div class="flex gap-x-2">
                    <input type="text" name="steps[]" x-model="step" class="input flex-1">
                    <button type="button" @click="steps.splice(index,1)">
                        <x-icons.cross class="text-red-500"/>
                    </button>
                </div>
            </template>

            <div class="flex gap-x-2">
                <input
                    type="text"
                    x-model="newStep"
                    placeholder="Do this thing"
                    class="input flex-1"
                >
                <button
                    type="button"
                    @click="steps.push(newStep.trim()); newStep=''"
                    :disabled="!newStep"
                >
                    <x-icons.plus/>
                </button>
            </div>
        </div>

        <div class="space-y-3">
            <label class="label">Links</label>

            <template x-for="(link, index) in links">
                <div class="flex gap-x-2">
                    <input type="url" name="links[]" x-model="link" class="input flex-1">
                    <button type="button" @click="links.splice(index,1)">
                        <x-icons.cross class="text-red-500"/>
                    </button>
                </div>
            </template>

            <div class="flex gap-x-2">
                <input
                    type="url"
                    x-model="newLink"
                    placeholder="https://example.com"
                    class="input flex-1"
                >
                <button
                    type="button"
                    @click="links.push(newLink.trim()); newLink=''"
                    :disabled="!newLink"
                >
                    <x-icons.plus/>
                </button>
            </div>
        </div>

        <div class="flex justify-end gap-x-3">
            <button
                type="reset"
                @click="resetForm(); show=false"
                class="btn btn-outlined"
            >
                Cancel
            </button>

            <button type="submit" class="btn">
                {{ $idea->exists ? 'Update' : 'Create' }}
            </button>
        </div>
    </form>
</x-modal>