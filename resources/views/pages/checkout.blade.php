<x-app-layout>
    <div class="w-full">
        <h1 class="text-center uppercase text-3xl">Checkout</h1>
    </div>

    <div class="w-2/4 mx-auto border rounded border-indigo-500">
        @auth
        @else
            <div class="p-5">
                <h3>Registration details</h3>
                <div>
                    <x-input-label for="name" :value="__('Name')"/>
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                                  required autofocus autocomplete="name"/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')"/>
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                                  required autocomplete="username"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')"/>

                    <x-text-input id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="new-password"/>

                    <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>

                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                  type="password"
                                  name="password_confirmation" required autocomplete="new-password"/>

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                       href="{{ route('login',['redirect' => urlencode( request()->getRequestUri() )]) }}">
                        {{ __('Already having an account?') }}
                    </a>
                </div>
                <div class="border-b-indigo-500"></div>
            </div>
        @endauth
        <div class="p-5">
            <h3>Payment details</h3>
            <div class="mt-4">
                <x-input-label for="card-number" :value="__('Card number')"/>
                <x-text-input id="card-number" class="block mt-1 w-full" type="text" name="card-number"
                              :value="old('card-number')"
                              required/>
                <x-input-error :messages="$errors->get('card-number')" class="mt-2"/>
            </div>
            <div class="mt-4">
                <x-input-label for="card-name" :value="__('Name on the card')"/>
                <x-text-input id="card-name" class="block mt-1 w-full" type="text" name="card-name"
                              :value="old('card-name')"
                              required/>
                <x-input-error :messages="$errors->get('card-name')" class="mt-2"/>
            </div>
            <div class="flex">
                <div class="mt-4">
                    <x-input-label for="card-date" :value="__('Expiration date')"/>
                    <x-text-input id="card-date" class="block mt-1 w-full" type="text" name="card-date"
                                  :value="old('card-date')"
                                  required placeholder="mm/yy"/>
                    <x-input-error :messages="$errors->get('card-date')" class="mt-2"/>
                </div>
                <div class="mt-4 ml-4">
                    <x-input-label for="card-cvv" :value="__('CVV')"/>
                    <x-text-input id="card-cvv" class="block mt-1 w-full" type="password" name="card-cvv"
                                  :value="old('card-cvv')" max="3" min="3"
                                  required/>
                    <x-input-error :messages="$errors->get('card-cvv')" class="mt-2"/>
                </div>

            </div>
            <div class="my-5 border border-indigo-500"></div>
        </div>
        <div>
            <h3>Checkout details</h3>
            <div class="flex justify-center">
                <x-primary-button>Checkout</x-primary-button>
            </div>
        </div>
    </div>
</x-app-layout>
