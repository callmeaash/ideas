@props([
    'name',
    'title',
    'errorBag' => 'default',
])

<div 
    x-data="{ show: @js($errors->getBag($errorBag)->isNotEmpty()), name: @js($name) }"
    x-show="show"
    @keydown.escape.window="show = false"
    @open-model.window="show = $event.detail === name"
    x-transition:enter="ease-out duration-200"
    x-transition:enter-start="opacity-0 -translate-y-4 -translate-x-4"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 -translate-y-4 -translate-x-4"
    style="display: none;"
    role="dialog"
    class="fixed z-50 inset-0 bg-black/50 flex items-center justify-center backdrop-blur-xs"
>

    <x-idea.card @click.away="show=false" class="max-w-2xl w-full mx-4 shadow-xl max-h-[80dvh] overflow-auto">
        <div class="flex justify-between">
            <h2 id="model-{{ $name }}-title" class="font-bold text-xl">{{ $title }}</h2>

            <x-icons.cross @click="show=false" class="cursor-pointer" />
        </div>

        <div>
            {{ $slot }}
        </div>
    </x-idea.card>

    
</div>