<x-filament-breezy::auth-card action="authenticate">

        <div class="w-full flex justify-center">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/DOST_seal.svg/1200px-DOST_seal.svg.png" style="width:64px;height:64px;">
        </div>


    <div class="w-full flex justify-center">
        <img src="https://scontent-mnl1-1.xx.fbcdn.net/v/t39.30808-6/364706014_259341823475862_5277198987590220895_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=730e14&_nc_ohc=fEcfroZ6o00AX9h0EFu&_nc_ht=scontent-mnl1-1.xx&oh=00_AfDxQUan9X6xbqhqhQmf6dBXse58zLIKQ4evCjDDGOOeWQ&oe=64CC0109" >
    </div>

    <div>
        <h2 class="font-bold tracking-tight text-center text-2xl">
            {{ __('filament::login.heading') }}
        </h2>
        @if(config("filament-breezy.enable_registration"))
        <p class="mt-2 text-sm text-center">
            {{ __('filament-breezy::default.or') }}
            <a class="text-primary-600" href="{{route(config('filament-breezy.route_group_prefix').'register')}}">
                {{ __('filament-breezy::default.registration.heading') }}
            </a>
        </p>
        @endif
    </div>

    {{ $this->form }}

    <x-filament::button type="submit" class="w-full" form="authenticate">
        {{ __('filament::login.buttons.submit.label') }}
    </x-filament::button>

    <div class="text-center">
        <a class="text-primary-600 hover:text-primary-700" href="{{route(config('filament-breezy.route_group_prefix').'password.request')}}">{{ __('filament-breezy::default.login.forgot_password_link') }}</a>
    </div>
</x-filament-breezy::auth-card>
