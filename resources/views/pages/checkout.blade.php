<x-app-layout>
    <div class="w-full">
        <h1 class="text-center uppercase text-3xl">Checkout</h1>
    </div>

    <div class="w-2/4 mx-auto border rounded border-indigo-500">
        <form method="post" action="/order">
            @csrf
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
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                      :value="old('email')"
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
                    <div class="mt-4 w-32">
                        <x-input-label for="card-date" :value="__('Expiration date')"/>
                        <x-text-input id="card-date" class="block mt-1 w-full" type="text" name="card-date"
                                      :value="old('card-date')"
                                      required placeholder="mm/yy"/>
                        <x-input-error :messages="$errors->get('card-date')" class="mt-2"/>
                    </div>
                    <div class="mt-4 ml-4 w-20">
                        <x-input-label for="card-cvv" :value="__('CVV')"/>
                        <x-text-input id="card-cvv" class="block mt-1 w-full" type="password" name="card-cvv"
                                      :value="old('card-cvv')" max="3" min="3"
                                      required/>
                        <x-input-error :messages="$errors->get('card-cvv')" class="mt-2"/>
                    </div>

                </div>
                <div class="mt-5 border border-indigo-500"></div>
            </div>
            <div class="px-5">
                <h3 class="mb-5 font-bold">Checkout details</h3>
                @if($plan === 'single')
                    <p><span class="inline-block font-bold w-32">Product:</span>
                        Single plan<sup class="text-red-700">*</sup>
                    </p>
                    <p><span class="inline-block font-bold w-32">Taxes:</span> 0.<sup>00</sup> BGN</p>
                    <p><span class="inline-block font-bold w-32">Price:</span> 49.<sup>00</sup> BGN</p>
                    <p><small><span class="text-red-700">*</span> {{__('The activation for 30 days of your plan will start immediately after the payment is confirmed.')}}</small></p>
                @else
                    <div class="mb-5">
                        <label for="students" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                            {{__('Select number of students:')}} <span id="display-selected">5</span>
                        </label>
                        <input
                            class="w-full"
                            type="range"
                            id="students"
                            name="students"
                            min="5"
                            max="50"
                            list="values"
                            value="5"
                        >
                        <datalist id="values" class="flex justify-between flex-row">
                            <option value="5" label="5"></option>
                            <option value="10" label="10"></option>
                            <option value="15" label="15"></option>
                            <option value="20" label="20"></option>
                            <option value="25" label="25"></option>
                            <option value="30" label="30"></option>
                            <option value="35" label="35"></option>
                            <option value="40" label="40"></option>
                            <option value="45" label="45"></option>
                            <option value="50" label="50"></option>
                        </datalist>
                    </div>
                    <div>
                        <p><span class="inline-block font-bold w-32">Product:</span> Multiple students plan<sup
                                class="text-red-700">*</sup></p>
                        <p><span class="inline-block font-bold w-32">Quantity:</span> <span id="table-count">5</span>
                            students</p>
                        <p><span class="inline-block font-bold w-32">Taxes:</span> 0.<sup>00</sup> BGN</p>
                        <p><span class="inline-block font-bold w-32">Price:</span> 39.<sup>00</sup> BGN</p>
                        <p><span class="inline-block font-bold w-32">Total:</span> <span
                                id="table-total">195.<sup>00</sup> BGN</span></p>
                        <p class="mt-3">
                            <small>
                                <span class="text-red-700">*</span>
                                {{__('Once the payment is confirmed you will be able to add manually each of your students. Each added student account will have 30 days of active plan to use the platform. There is no time limite for addin the students. ')}}
                            </small>
                        </p>
                    </div>
                    <script>
                        const countStudents = document.querySelector("#display-selected")
                        const input = document.getElementById("students")
                        const tableCount = document.getElementById("table-count")
                        const tableTotal = document.getElementById("table-total")
                        input.addEventListener("input", (event) => {
                            const students = parseInt(event.target.value);
                            const total = students * 39;
                            countStudents.innerText = students;
                            tableCount.innerText = students;
                            tableTotal.innerHTML = total + '.<sup>00</sup>';
                        })
                    </script>
                @endif
                <div class="flex justify-center my-4">
                    <x-primary-button>Checkout</x-primary-button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
