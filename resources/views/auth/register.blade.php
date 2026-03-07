<x-layout>
    <x-form title="Register Now" description="Join and share your ideas.">
        <form action="{{ route('register.store') }}" method="post" class="mt-10 space-y-4">
            @csrf

            <x-form.field label="Name" name="name"/>

            <x-form.field label="Email" name="email" type="email" />

            <x-form.field label="Password" name="password" type="password" />

            <x-form.field label="Confirm Password" name="password_confirmation" type="password" />

            <button data-test="register-submit" type="submit" class="btn mt-2 h-10 w-full">Register</button>
        </form>
    </x-form>
</x-layout>