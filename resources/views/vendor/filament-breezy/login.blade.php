<x-filament-breezy::auth-card action="authenticate">




    <div class="w-full flex justify-center">
        <img src="https://scontent.fmnl25-3.fna.fbcdn.net/v/t39.30808-6/363837890_3508091356079333_2137715103987440528_n.jpg?_nc_cat=106&cb=99be929b-59f725be&ccb=1-7&_nc_sid=730e14&_nc_eui2=AeEEC7bkf2v25w7naoHArw2VIwlFS_BuXYUjCUVL8G5dhcu108gzNWKG7sRyBBFpUOLCJLORujqTxhNVneP04zss&_nc_ohc=IYR6THRDrXUAX8Q9B6R&_nc_ht=scontent.fmnl25-3.fna&oh=00_AfBmqwhcmebopFM-VSppoID03NOvcVuBlifJHkh8-UNkgA&oe=64CEBAA7" >
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
