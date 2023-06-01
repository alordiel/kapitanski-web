@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-subheader title="{{__('My exam')}}"/>
    </x-slot>

    @if(session()->has('message'))
        <x-success-message message="{{session('message')}}"/>
    @endif

    @php
        $subscription_expired = false;
        $inactive_subscription = false;
        $active_subscription = false;
        $subscriptions = $user->subscriptions;
        if (!empty($subscriptions)){
            $today = date("Y-m-d");
            foreach ($subscriptions as $subscription) {
                if ($subscription->expires_on === null) {
                    $inactive_subscription = true;
                    continue;
                }
                $expiration_date = date("Y-m-d", strtotime($subscription->expires_on));
                if($today < $expiration_date) {
                    $active_subscription = true;
                    break;
                }
            }

            if (!$inactive_subscription && !$active_subscription)  {
                // the user have only expired subscriptions and no new orders
                $subscription_expired = true;
            }
        }
    @endphp

    @if($subscription_expired)
        <h3 class="text-center font-bold text-3xl">Your subscription has expired</h3>
        <h4 class="text-center font-bold text-2xl">
            {!! sprintf(__("You can buy a new subscription from <a href='%s' title='Buy a plan'>here</a>."),route('buy')) !!}
        </h4>
    @elseif($inactive_subscription && !$active_subscription)
        {{-- User have a subscription that is not activate, so let's suggest activating it --}}
        {{-- Also we check for not-expired subscriptions, it is possible that the user has two subscriptions, one active and one inactive --}}
        <div class="flex justify-center flex-wrap">
            <p class="my-8 text-center w-full text-xl font-bold">
                {{__("Your subscription is still inactive. You can activate it by clicking the button below.")}}
            </p>
            <div class="w-1/4">
                <div class="w-48 mx-auto mb-4">
                    <form action="{{route('subscription.activate')}}" method="POST">
                        @csrf
                        <x-primary-button>{{__('Activate plan')}}</x-primary-button>
                    </form>
                </div>
                <small>
                    {{__('By clicking the "Activate plan" button you will start the 30 days period for which you will have access to full exam functionality.')}}
                </small>
            </div>
        </div>
    @elseif($active_subscription)
        You have active subscription.
    @else
        <h3 class="text-center font-bold text-3xl">You don't have any subscription yet</h3>
        <h4 class="text-center font-bold text-2xl">
            {!! sprintf(__("You can buy a new subscription from <a href='%s' title='Buy a plan'>here</a>."),route('buy')) !!}
        </h4>
    @endif

</x-app-layout>
