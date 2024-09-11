<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <x-input-label for="name"/>
            <x-text-input  placeholder="Username" id="name" class="w-full p-3 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" />
            <x-text-input  placeholder="Email" id="email" class="w-full p-3 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4 relative">
            <x-input-label for="password" />

            <x-text-input id="password" class="w-full p-3 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500"
                            type="password"
                            name="password"
                            placeholder="Password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4 relative">
            <x-input-label for="password_confirmation"/>

            <x-text-input id="password_confirmation" class="w-full p-3 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500"
                            type="password"
                            name="password_confirmation"
                            placeholder="Confirm Password" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-white hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
