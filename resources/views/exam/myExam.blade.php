@php
    use \App\Models\Subscription;
    use Illuminate\Support\Facades\Auth;
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-subheader title="{{__('My exam')}}"/>
    </x-slot>
    @php
        $subscription_expired = false;
        $activate_subscription = false;
        $active_subscription = false;
        $go_and_buy_plan = true; // suggested only when not order or all subscriptions have expired

        $user = Auth::user();
        // get subscriptions for current user
        $subscriptions = $user->subscriptions;
        $orders = $user->orders;

        if (empty($subscriptions) || count($subscriptions) === 0) {
            if(! empty($orders)){
                // check if order has a subscription attached or needs one to be activated
                foreach ($orders as $order) {
                    if ($order->credits > $order->used_credits) {
                        $activate_subscription = true;
                        $go_and_buy_plan = false;
                        break;
                    }
                }
            }
        } else {
            $today = date("Y-m-d");
            foreach ($subscriptions as $subscription) {
                $expiration_date = date("Y-m-d", strtotime($subscription->expires_on));
                if($today < $expiration_date) {
                    $active_subscription = true;
                    $subscription_expired = false;
                    $go_and_buy_plan = false;
                    break;
                }
            }

            // But may be there is a new order so let's check for it too
            if (!empty($orders)) {
                foreach ($orders as $order) {
                     if ($order->credits > $order->used_credits) {
                        $activate_subscription = true;
                        $subscription_expired = false;
                        $go_and_buy_plan = false;
                        break;
                    }
                }
            }
            if (!$activate_subscription && !$active_subscription)  {
                // the user have only expired subscriptions and no new orders
                $subscription_expired = true;
            }
        }
    @endphp

    @if($subscription_expired)
        Your subscription has expired
    @endif

    @if($go_and_buy_plan)
        No subscriptions found.
        go and Buy subscription
    @endif

    {{-- User have an order that hasn't got a subscription so let's suggest activating it --}}
    @if($activate_subscription)
        <div class="flex justify-center flex-wrap">
            <p class="my-8 text-center w-full text-xl font-bold">{{__("Your subscription is still inactive. You can activate it by clicking the button below.")}}</p>
            <div class="w-1/4">
                <div class="w-48 mx-auto mb-4">
                    <form action="{{route('subscription.activate')}}" method="POST">
                        <x-primary-button>{{__('Activate plan')}}</x-primary-button>
                    </form>
                </div>
                <small>{{__('By clicking the "Activate plan" button you will start the 30 days period for which you will have access to full exam functionality.')}}</small>
            </div>
        </div>
    @endif

    @if($active_subscription)
        You have active subscription
    @endif

</x-app-layout>
