<div class="flex min-h-[calc(100dvh-4rem)] items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="text-center">
            <h1 class="text-3xl font-display">{{ $title }}</h1>
            <p class="text-muted-foreground font">{{ $description }}</p>
        </div>
        
        {{ $slot }}
    </div>
</div>