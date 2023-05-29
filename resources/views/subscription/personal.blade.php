@php
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $subscriptions = $user ? $user->subscriptions : [];
    $orders = $user ? $user->orders : [];
    $order_status = [
        'pending' => __('Pending payment'),
        'cancelled' => __('Cancelled'),
        'completed' => __('Completed'),
        'refunded' => __('Refunded'),
    ];

@endphp

<x-app-layout>
    <x-slot name="header">
        <x-subheader title="{{__('My subscriptions')}}"/>
    </x-slot>
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        @if(!empty($orders) && count($orders) > 0)
            <div class="flex flex-wrap">
                @foreach($orders as $order)

                    @if(count($order->subscriptions) === 1)

                        @php
                            $subscription = $order->subscriptions[0];
                            $created_on = date('d-m-Y', strtotime($subscription->created_at));
                            $expires_on = date('d-m-Y', strtotime($subscription->expires_on));
                            $is_active  = $expires_on > date("Y-m-d");
                            $subscriptions_status = $is_active ? __('Active') : __('Expired');
                            $expiration_date = $is_active ? __('Expires on') : __('Expired on');
                        @endphp
                        <div class="w-64 border rounded px-3 py-5">
                            <p><strong>{{__('Status')}}:</strong>
                                <span
                                    class="{{ $is_active ? 'bg-green-400' : 'bg-red-500'}} inline-block text-white rounded px-3">
                                {{ $subscriptions_status }}
                            </span>
                            </p>
                            <p><strong>{{__('Exam')}}:</strong> {{$subscription->exam->name}} <br></p>
                            <p><strong>{{__('Started on')}} :</strong> {{$created_on}}</p>
                            <p><strong>{{$expiration_date}} :</strong> {{$expires_on}}</p>
                            @if($order->credits === 1)
                                <p><a href="#">{{'Download Invoice'}}</a></p>
                            @endif
                        </div>
                    @elseif(count($order->subscriptions) > 1)
                        has order with more than 1 credit
                    @else
                        has only order        </div>
                    @endif
                @endforeach
            </div>
        @elseif(!empty($subscriptions)  && count($subscriptions) > 0)
            <div class="flex flex-wrap">
                @foreach($subscriptions as $subscription)
                    <div>
                        Exam: {{$subscription->exam->name}} |
                        Started on: {{date('d-m-Y', strtotime($subscription->created_at))}} |
                        Expires on: {{date('d-m-Y', strtotime($subscription->expires_on))}} |
                        By: {{$subscription->createdBy->name}}
                    </div>
                @endforeach
            </div>
        @else
            <h3 class="text-2xl text-center font-bold mb-5">{{__("You don't have any subscriptions yet.")}}</h3>
            <p class="text-center">{{__('If you account was created from some of our partners please contact them for further instructions.')}}</p>
            <p class="text-center">{!! sprintf(__("You can buy a new plan from <a href='%s' title='Buy a plan'>here</a>"),route('buy')) !!}</p>
        @endif
    </div>
</x-app-layout>
