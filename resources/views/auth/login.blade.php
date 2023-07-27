<x-guest-layout>
    <x-authentication-card>

        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>


        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf



            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">

                </label>
            </div>

            <div class="flex items-center justify-end mt-4">


                <x-reset-password-button url="http://127.0.0.1:8000/admin/login" >
                    {{ __('Go back to Log In') }}
                </x-reset-password-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
