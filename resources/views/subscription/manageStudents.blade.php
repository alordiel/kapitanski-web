@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\User;
    $user = Auth::user();
    $oldValues = [];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-subheader title="{{__('Manage subscriptions')}}"/>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="mb-5">
                    <div class="flex justify-between">
                        <h2 class="text-3xl font-bold mb-5">{{ sprintf( __("Order #%d") ,$order->id )}}</h2>
                        <a href="{{route('subscription.personal')}}">{{ __('My orders') }}</a>
                    </div>
                    <p>{{sprintf( __("This order has %d used credits from total of %d credits."), $order->used_credits, $order->credits )}}</p>
                </div>

                @if(count($errors->general->all()) > 0  )
                    <x-input-error :messages="$errors->general->all()" class="my-4"/>
                @endif

                @if(session()->has('message'))
                    <x-success-message message="{{session('message')}}"/>
                @endif

                @if(count($errors->form->all()) > 0  )
                    @php($oldValues = old())
                @endif
                {{-- This is the list of the current subscriptions --}}
                @php($subscriptions = $order->subscriptions)
                @php($credits_left = $order->credits - $order->used_credits)

                @if(count($subscriptions) > 0)
                    <div class="mb-5 pt-5 border-t-2  dark:border-indigo-500 border-gray-300">
                        <h3 class="text-2xl">{{ __('List of subscriptions') }}</h3>
                    </div>
                    <div class="mb-5 grid grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($subscriptions as $subscription)
                            <div
                                class="border dark:border-indigo-500 border-gray-300 rounded max-w-4xl px-3 py-5 ">
                                <p>
                                    <strong>{{ __('Name') }}:</strong> {{ $subscription->user['name'] }}
                                </p>
                                <p>
                                    <strong>{{ __('Email') }}:</strong> {{ $subscription->user['email'] }}
                                </p>
                                <p>
                                    <strong>{{ __('Subscription status') }}:</strong>
                                    @if($subscription['expires_on'] === null)
                                        {{ __('Not activated')}}
                                    @elseif( date('Y-m-d', strtotime($subscription['expires_on'])) < date('Y-m-d'))
                                        {{__('Expired')}}
                                    @else
                                        {{ __('Activated')}}
                                    @endif
                                </p>

                                @if($subscription['expires_on'] !== null)
                                    <p>
                                        <strong>{{__('Expires on')}}:</strong> {{ $subscription['expires_on'] }}
                                    </p>
                                @endif

                                @if($user->hasPermissionTo('view-students-statistics') && count(User::find($subscription['user_id'])->examTakings) > 0 )
                                    <p>
                                        <a href="#">{{ __('View stats') }}</a>
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- The form for subscribing the students --}}
                @if($order->credits > $order->used_credits)
                    <div>
                        <div class="mb-5 pt-5 border-t-2  dark:border-indigo-500 border-gray-300">
                            <h3 class="text-2xl">{{ __('Add students') }}</h3>
                            @if($credits_left=== 1)
                                <p>{{ __('You can add one more student.') }}</p>
                            @else
                                <p>{{ sprintf(__('You can add %d more students.'), $credits_left ) }}</p>
                            @endif
                        </div>
                        <form action="{{ route('subscription.students.store') }}" method="POST" class="mb-5"
                              id="store-students">
                            @csrf

                            @php($index = 0)
                            @php($form_errors = $errors->form->getMessages())

                            @forelse($oldValues as $oldValue)
                                @php($errorEmail = !empty($form_errors[$index . '.email'][0]) ?  $form_errors[$index . '.email'][0] : '')
                                @php($errorName =  !empty($form_errors[$index . '.name'][0]) ?  $form_errors[$index . '.name'][0] : '')
                                <x-student-row
                                    :index="$index"
                                    :name="$oldValue['name']"
                                    :email="$oldValue['email']"
                                    :error-name="$errorName"
                                    :error-email="$errorEmail"
                                />
                                @php($index++)
                            @empty
                                <x-student-row :index="0"/>
                            @endforelse

                            <div id="add-another-student" class="mb-4">
                                {{-- this div is used as wrapper for adding the rest of the students --}}
                            </div>
                            <div class="flex justify-between flex-wrap max-w-2xl">
                                @if($credits_left > 1)
                                    <x-secondary-button id="add-field">{{ __('Add empty field') }}</x-secondary-button>
                                @endif
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>
                            <input type="hidden" value="{{$order->id}}" name="orderId">
                            <input type="hidden" value="1" name="number-of-rows" id="number-of-rows">
                        </form>
                        <div
                            class="text-orange-700 dark:text-yellow-500 border rounder border-orange-700 dark:border-yellow-500 py-2 px-4 border-l-4">
                            <p>
                                <svg class="inline-block mr-2" stroke="currentColor" fill="currentColor" stroke-width="0"
                                     viewBox="0 0 576 512"
                                     height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"></path>
                                </svg>
                                {{ __('Note that once you save the list you will not be able to edit the user\'s email.') }}
                            </p>
                            <p class="pl-7">{{ __('Adding the students won\'t automatically activate their 30 days subscription period.') }}</p>
                            <p class="pl-7" >{{ __('They will be able to activate the subscription whenever they want.') }}</p>
                        </div>
                    </div>

                    @if($credits_left > 0)
                        <script>
                            const availableCredits = {{ $credits_left }};
                            document.addEventListener('DOMContentLoaded', function () {
                                // we always have this first row there
                                let addedElements = 1;

                                document.getElementById('store-students').addEventListener('submit', function (event) {

                                    let hasErrors = false;
                                    document.getElementById('number-of-rows').value = addedElements;
                                    console.log(document.getElementById('number-of-rows').value)
                                    // validate the form
                                    for (let i = 0; i < addedElements; i++) {
                                        const row = i + 1;
                                        const nameError = document.getElementById('name-error-' + row);
                                        const emailError = document.getElementById('email-error-' + row);
                                        // check if fields actually exist
                                        if (nameError === null || emailError === null) {
                                            continue;
                                        }
                                        // Clear any old errors
                                        nameError.innerText = '';
                                        nameError.style.display = 'none';
                                        emailError.innerText = '';
                                        emailError.style.display = 'none';

                                        // Check for errors the name and email fields;
                                        if (document.getElementById('name-' + row).value === '') {
                                            nameError.innerText = "{{ __('This field is required') }}";
                                            nameError.style.display = 'block';
                                            hasErrors = true;
                                        }
                                        if (document.getElementById('email-' + row).value === '') {
                                            emailError.innerText = "{{ __('This field is required') }}";
                                            emailError.style.display = 'block';
                                            hasErrors = true;
                                        }
                                        if (!document.getElementById('email-' + row).validity.valid) {
                                            emailError.innerText = "{{ __('This seems to be invalid email') }}";
                                            emailError.style.display = 'block';
                                            hasErrors = true;
                                        }
                                    }
                                    // cancel submission if we have errors
                                    if (hasErrors) {
                                        event.preventDefault();
                                        return false;
                                    }

                                    return true;
                                });

                                if (document.getElementById('add-field') !== null) {
                                    document.getElementById('add-field').addEventListener('click', function () {
                                        // Prevent adding new rows if we are out of credits
                                        if (availableCredits - addedElements === 0) {
                                            return
                                        }
                                        const button = this;
                                        const counter = addedElements + 1;
                                        const wrapper = document.getElementById('add-another-student')
                                        const newRow = '<div class="flex flex-wrap mb-4" data-number="0"><div class="mr-5"><label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="name">Full name</label><input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-60 lg:w-72 xl:w-80" id="name" type="text"><p class="text-sm text-red-600 dark:text-red-400 space-y-1" style="display:none"></p></div><div><label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="email">Email</label><input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-60 lg:w-72 xl:w-80" id="email" type="email"><p class="text-sm text-red-600 dark:text-red-400 space-y-1" style="display:none"></div><button class="remove-row rounded-full border-2 border-red-500 text-red-500 block w-7 h-7 ml-5 mt-7 flex items-center justify-center" type="button">X</button></div>';
                                        const range = document.createRange();
                                        range.selectNodeContents(wrapper);
                                        const fragment = range.createContextualFragment(newRow);

                                        // change the names, ids, and `for`
                                        const nameID = 'name-' + counter// we add 2 because we already have name-1 and our counter starts from 0
                                        const emailID = 'email-' + counter
                                        const nameErrorID = 'name-error-' + counter
                                        const emailErrorID = 'email-error-' + counter
                                        const nameLabel = fragment.firstChild.children[0].children[0];
                                        const nameInput = fragment.firstChild.children[0].children[1];
                                        const nameError = fragment.firstChild.children[0].children[2];

                                        nameLabel.setAttribute('for', nameID);
                                        nameInput.setAttribute('name', nameID);
                                        nameInput.id = nameID;
                                        nameError.id = nameErrorID;

                                        const emailLabel = fragment.firstChild.children[1].children[0];
                                        const emailInput = fragment.firstChild.children[1].children[1];
                                        const emailError = fragment.firstChild.children[1].children[2];

                                        emailLabel.setAttribute('for', emailID);
                                        emailInput.setAttribute('name', emailID);
                                        emailInput.id = emailID;
                                        emailError.id = emailErrorID;

                                        fragment.firstChild.dataset.number = counter;

                                        fragment.firstChild.children[2].addEventListener('click', function (e) {
                                            e.target.parentElement.remove();
                                            addedElements--;
                                            // show the "add" button if there are still some more credits
                                            if (availableCredits - addedElements !== 0) {
                                                button.style.opacity = '1';
                                            }
                                        });
                                        wrapper.appendChild(fragment);
                                        addedElements++;

                                        if (availableCredits - addedElements === 0) {
                                            this.style.opacity = 0;
                                        }
                                    });
                                }
                            });
                        </script>
                    @endif
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
