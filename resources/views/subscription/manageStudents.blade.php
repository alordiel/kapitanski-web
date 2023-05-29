@php
    use \App\Models\Subscription;
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-subheader title="{{__('Manage subscriptions')}}"/>
    </x-slot>

    @if(session()->has('message'))
        <x-success-message message="{{session('message')}}"/>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <p>{{sprintf( __("Order #%d has %d used credits from total of %d credits.") ,$order->id, $order->used_credits, $order->credits )}}</p>
                @role('student-partner')
                <p>{{ __('You can manage your the other accounts below.') }}</p>
                @else
                    <p>{{ __('You can manage your students below') }}</p>
                @endrole
                <p class="text-red-600 dark:text-yellow-500">
                    <svg class="inline-block" stroke="currentColor" fill="currentColor" stroke-width="0"
                         viewBox="0 0 576 512"
                         height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"></path>
                    </svg>
                    {{ __('Note that once you save the list you will not be able to edit the user\'s email.') }}
                </p>
                {{-- This is the list of the current subscriptions --}}
                @php($subscriptions = $order->subscriptions)
                @if(count($subscriptions) > 0)
                <div>
                    <ul>
                    @foreach($subscriptions as $subscription)
                        <li>
                            {{$subscription->user->name ($subscription->user->name)}}
                            @if($user->hasPermissionTo('view-students-statistics'))
                                <a href="#">{{ __('View stats') }}</a>
                            @endif
                        </li>
                    @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
