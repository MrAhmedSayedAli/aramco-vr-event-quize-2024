<x-new-event>
    {{--    <div class="min-h-screen relative sm:flex sm:justify-center sm:items-center">--}}
    <div class="relative sm:flex sm:justify-center sm:items-center">
        <form action="" method="post" class="flex flex-col p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            @csrf
            {{--
                    <div class="flex justify-center mb-3">
                        <img src="{{asset('images/logo.png')}}" alt="">
                    </div>
                    --}}
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">Information Protection Department</h5>
            <h3 class="mb-3 font-bold text-gray-700 dark:text-gray-400 text-center" style="font-size: 22pt">Welcome to the Cybersecurity Challenge</h3>
{{--            <p class="mb-3 text-center font-bold">Please Enter Your E-mail and Mobile number for Get Your Code</p>--}}
            <hr class="w-48 h-1 mx-auto my-5 bg-gray-100 border-0 rounded dark:bg-gray-700">


            <div>
                <x-input-label for="email" :value="__('Email')" />
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
                <x-primary-button class="ml-4">
                    {{ __('Get Code') }}
                </x-primary-button>
            </div>

        </form>
    </div>
{{--    <a href="{{route('player.register')}}">go HOME</a>--}}
</x-new-event>
