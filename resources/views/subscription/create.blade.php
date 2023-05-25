@php
    use App\Models\Exam;
    use App\Models\User;
    use App\Models\Order;

    $exams = Exam::all();
    $users = User::all();
    $orders = Order::whereColumn('credits','>','used_credits')->get();// Show only orders with unused credits
@endphp
<x-app-layout>
    <x-slot name="header">
        <x-subheader title="Add new subscription" icon="all" button-text="All subscriptions"
                     url="{{route('subscription.manage')}}"/>
    </x-slot>

    <form action="{{route('subscription.store')}}" method="POST">
        @csrf
        <p class="mb-3">
            <x-input-label for="exam-name" :value="__('Exam name')"/>
            <select
                name="exam_id"
                id="exam-name"
                required
                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            >
                @foreach($exams as $exam)
                    <option value="{{$exam->id}}" @selected(old('exam_id') === $exam->id)>{{$exam->name}}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('exam_id')" class="mt-2"/>
        </p>
        <p class="mb-3">
            <x-input-label for="user" :value="__('Customer')"/>
            <select
                name="user_id"
                id="user"
                required
                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            >
                @foreach($users as $user)
                    <option value="{{$user->id}}" @selected(old('user_id') === $user->id)>{{$user->name}}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('user_id')" class="mt-2"/>
        </p>
        <p class="mb-3">
            <x-input-label for="order" :value="__('Attache order')"/>
            <select
                name="order_id"
                id="order"
                required
                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            >
                @foreach($orders as $order)
                    <option value="{{$order->id}}" @selected(old('order_id') === $order->id)>Order #{{$order->id}}
                        ({{$order->user->name}})
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('order_id')" class="mt-2"/>
        </p>
        <p class="mb-3">
            <x-input-label for="created_at" :value="__('Started on')"/>
            <x-text-input
                type="date"
                id="created_at"
                name="created_at"
                class="w-1/4 block"
                :value="old('created_at')"
            />
            <x-input-error :messages="$errors->get('created_at')" class="mt-2"/>
        </p>
        <p class="mb-3">
            <x-input-label for="expires_on" :value="__('Expires on')"/>
            <x-text-input
                type="date"
                id="expires_on"
                name="expires_on"
                class="w-1/4 block"
                :value="old('expires_on')"
            />
            <x-input-error :messages="$errors->get('expires_on')" class="mt-2"/>
        </p>
        <x-primary-button> Create </x-primary-button>
    </form>
</x-app-layout>
