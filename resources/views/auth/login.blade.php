<x-layout>
    <x-form title="Sign In" description="Sign in to your account.">
        <form action="{{ route('login.store') }}" method="post" class="mt-10 space-y-4">
            @csrf

            <x-form.field label="Email" name="email" type="email" />

            <x-form.field label="Password" name="password" type="password" />

            <button data-test="login-submit" type="submit" class="btn mt-2 h-10 w-full">Sign In</button>
        </form>
    </x-form>
</x-layout>