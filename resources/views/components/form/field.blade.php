@props(
    ['label', 'name', 'type' => 'text']
)

<div class="space-y-2">
    @if ($label)
        <label for="{{ $name }}" class="label">{{ $label }}</label>
    @endif

    @if($type === 'password')
        <div class="relative" x-data="{ show: false }">
            <input :type="show ? 'text' : 'password'" name="{{ $name }}" id="{{ $name }}" class="input w-full pr-10" autocomplete="off" value="{{ old($name, '') }}" {{ $attributes }}>
            <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 cursor-pointer">

                <x-icons.eye-open x-show="!show" />
                <x-icons.eye-closed x-show="show" />
            </button>
        </div>
    @elseif ($type === 'textarea')
        <textarea name="{{ $name }}" id="{{ $name }}" class="input textarea" autocomplete="off" {{ $attributes }}>{{ old($name, '') }}</textarea>
    @else
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" class="input" autocomplete="off" value="{{ old($name, '') }}" {{ $attributes }}>
    @endif
    
    <x-form.error name="{{ $name }}" />
</div>
