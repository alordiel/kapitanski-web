@php
use App\Models\Exam;
$exams = Exam::all();
@endphp
<x-app-layout>
    <x-slot name="header">
            <x-subheader title="Edit Subscription" icon="all" button-text="All subscriptions" url="{{route('subscription.manage')}}"/>
    </x-slot>

    @if(session()->has('message'))
        <x-success-message message="{{session('message')}}"/>
    @endif

    <form action="{{route('subscription.update', ['subscription'=> $subscription])}}" method="POST">
        @csrf
        @method('PUT')
        <p class="mb-3">
            <x-input-label for="exam-name" :value="__('Exam name')"/>
            <select
                name="exam_id"
                id="exam-name"
                required
                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            >
                @foreach($exams as $exam)
                <option value="{{$exam->id}}" @selected($subscription->exam_id === $exam->id)>{{$exam->name}}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('exam_id')" class="mt-2"/>
        </p>
        <p class="mb-3">
            <x-input-label for="created_at" :value="__('Started on')"/>
            <x-text-input
                type="date"
                id="created_at"
                name="created_at"
                class="w-1/4 block"
                :value="date('Y-m-d', strtotime($subscription->created_at))"
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
                :value="date('Y-m-d', strtotime($subscription->expires_on))"
            />
            <x-input-error :messages="$errors->get('expires_on')" class="mt-2"/>
        </p>
        <input type="hidden" name="order_id" value="{{$subscription->order_id}}">
        <input type="hidden" name="user_id" value="{{$subscription->user_id}}">
        <input type="hidden" name="created_by" value="{{$subscription->created_by}}">
        <x-primary-button> Update </x-primary-button>
    </form>
</x-app-layout>
