@props(
    ['label', 'name', 'type' => 'text']
)

<div class="space-y-2">
    <label for="{{ $name }}" class="label">{{ $label }}</label>

    @if($type === 'password')
        <div class="relative" x-data="{ show: false }">
            <input :type="show ? 'text' : 'password'" name="{{ $name }}" id="{{ $name }}" class="input w-full pr-10" autocomplete="off" value="{{ old($name, '') }}">
            <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 cursor-pointer">
                {{-- Eye open icon --}}
                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                {{-- Eye closed icon --}}
                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 012.31-3.894M6.938 6.938A9.966 9.966 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.043 5.062M15 12a3 3 0 11-6 0" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                </svg>
            </button>
        </div>
    @else
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" class="input" autocomplete="off" value="{{ old($name, '') }}">
    @endif

    @error($name)
        <p class="text-red-500 text-xs">{{ $message }}</p>
    @enderror
</div>
