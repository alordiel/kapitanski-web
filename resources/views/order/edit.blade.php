<x-app-layout>
    <x-slot name="header">
            <x-subheader title="Edit Order" icon="all" button-text="All orders" url="{{route('order.manage')}}"/>
    </x-slot>

    @if(session()->has('message'))
        <x-success-message message="{{session('message')}}"/>
    @endif

    <form action="{{route('order.update', ['order'=> $order])}}" method="POST">
        @csrf
        @method('PUT')

        <p class="mb-3">
            {{__('Customer name') . ':' . $order->user->name}} <br>
            {{__('Order created on') . ':' . $order->created_at }}
        </p>
         <p class="mb-3">
            <x-input-label for="status" :value="__('Order status')"/>
              <select
                  name="order_status"
                  id="status"
                  class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
              >
                  <option value="pending" @selected($order->order_status === 'pending')>{{__('Pending payment')}}</option>
                  <option value="cancelled" @selected($order->order_status === 'cancelled')>{{__('Cancelled')}}</option>
                  <option value="completed" @selected($order->order_status === 'completed')>{{__('Completed')}}</option>
                  <option value="refunded" @selected($order->order_status === 'refunded')>{{__('Refunded')}}</option>
              </select>

        </p>
        <p class="mb-3">
            <x-input-label for="credits" :value="__('Number of credits')"/>
            <x-text-input
                type="number"
                id="credits"
                name="credits"
                class="w-1/4 block"
                :value="$order->credits"
            />
        </p>
        <p class="mb-3">
            <x-input-label for="single_price" :value="__('Single price')"/>
            <x-text-input
                type="number"
                id="single_price"
                name="single_price"
                class="w-1/4 block"
                :value="$order->single_price"
            />
        </p>
          <p class="mb-3">
            <x-input-label for="payment_type" :value="__('Payment method')"/>
            <x-text-input
                type="text"
                disabled
                id="payment_type"
                name="payment_type"
                class="w-1/4 block"
                :value="$order->payment_method"
            />
        </p>
        <p class="mb-3">
            <x-input-label for="payment_id" :value="__('Payment reference')"/>
            <x-text-input
                type="text"
                id="payment_id"
                name="payment_id"
                class="w-1/4 block"
                :value="$order->payment_id"
            />
        </p>
        <x-primary-button> Update </x-primary-button>
    </form>
</x-app-layout>
