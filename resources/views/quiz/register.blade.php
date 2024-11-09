<x-new-event>
{{--    <div class="min-h-screen relative sm:flex sm:justify-center sm:items-center">--}}
    <div class="row">
        <div class="col">
    <div class="relative sm:flex sm:justify-center sm:items-center">
    <form action="" method="post" class="flex flex-col p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    @csrf
<div class="card-body">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">Information Protection Department</h5>
        <h3 class="mb-3 font-bold text-gray-700 dark:text-gray-400 text-center" style="font-size: 22pt">Welcome to the Cybersecurity Challenge</h3>
{{--        <p class="mb-3 text-center font-bold">Please Enter Your Name ,E-mail and Mobile number for Registration</p>--}}
        <hr class="w-48 h-1 mx-auto my-5 bg-gray-100 border-0 rounded dark:bg-gray-700">

        <div class="row">
            <div class="col">
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
        </div>
        <hr />
        <br>
        <div>
            <x-input-label for="email" :value="__('Email Address (Personal)')" />
            <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" required autofocus autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <hr />
        <br>
        <div>
            <x-input-label for="phone" :value="__('Mobile number')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autofocus autocomplete="phone" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>


        <hr />
        <br>

        <div class="flex items-center justify-center mt-4">
{{--
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('player.login') }}">
                {{ __('Already Have Code ?') }}
            </a>
            --}}
            <x-primary-button class="">
                {{ __('Register') }}
            </x-primary-button>
        </div>

    <div class="flex items-center justify-center mt-4">
        <hr />
        <br />
        <a href="{{route('player.forget')}}">Forgot ID Click Here</a>
    </div>
</div>

    </form>

    </div>

    </div>
    </div>

    </x-new-event>
