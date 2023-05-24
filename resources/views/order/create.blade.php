@php
use App\Models\User
@endphp
 <x-app-layout>
    <x-slot name="header">
        <x-subheader title="Add Order" icon="all" button-text="All orders" url="{{route('order.manage')}}"/>
    </x-slot>

    @if(session()->has('message'))
        <x-success-message message="{{session('message')}}"/>
    @endif

    <form action="{{route('order.store')}}" method="POST">
        @csrf

        <p class="mb-3">
            @php
            $users = User::all();
            var_dump($errors);
            @endphp
            <x-input-label for="user_id" :value="__('Customer name')"/>
            <select
                name="user_id"
                id="user_id"
                required
                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            >
                <option value="">--- {{__('Select customer')}} ---</option>
                @foreach($users as $user)
                    <option value="{{$user->id}}" @selected(old('user_id') === $user->id)>
                        {{$user->name . ' (' . $user->email . ')'}}
                    </option>
                @endforeach
            </select>
        </p>
        <p class="mb-3">
            <x-input-label for="order_status" :value="__('Order status')"/>
            <select
                name="order_status"
                id="order_status"
                required
                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            >
                <option value="pending" @selected(old('order_status') === 'pending')>{{__('Pending payment')}}</option>
                <option value="cancelled" @selected(old('order_status') === 'cancelled')>{{__('Cancelled')}}</option>
                <option value="completed" @selected(old('order_status') === 'completed')>{{__('Completed')}}</option>
                <option value="refunded" @selected(old('order_status') === 'refunded')>{{__('Refunded')}}</option>
            </select>
             <x-input-error :messages="$errors->get('order_status')" class="mt-2" />
        </p>
        <p class="mb-3">
            <x-input-label for="credits" :value="__('Number of credits')"/>
            <x-text-input
                type="number"
                id="credits"
                required
                name="credits"
                class="w-1/4 block"
                :value="old('credits')"
            />
             <x-input-error :messages="$errors->get('credits')" class="mt-2" />
        </p>
        <p class="mb-3">
            <x-input-label for="single_price" :value="__('Single price')"/>
            <x-text-input
                required
                type="number"
                id="single_price"
                name="single_price"
                class="w-1/4 block"
                :value="old('single_price')"
            />
             <x-input-error :messages="$errors->get('single_price')" class="mt-2" />
        </p>
        <p class="mb-3">
            <x-input-label for="payment_method" :value="__('Payment method')"/>
             <select
                name="payment_method"
                id="payment_method"
                required
                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            >
                 <option value="paysera" @selected(old('payment_method') === 'paysera')>Paysera Card payment</option>
                 <option value="sepa" @selected(old('payment_method') === 'sepa')>Bank Transfer (SEPA)</option>
             </select>
             <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
        </p>
        <p class="mb-3">
            <x-input-label for="payment_id" :value="__('Payment reference')"/>
            <x-text-input
                required
                type="text"
                id="payment_id"
                name="payment_id"
                class="w-1/4 block"
                :value="old('payment_id')"
            />
             <x-input-error :messages="$errors->get('payment_id')" class="mt-2" />
        </p>
        <input type="hidden" name="invoice_number" value="1">
        <x-primary-button>Create</x-primary-button>
    </form>
</x-app-layout>
