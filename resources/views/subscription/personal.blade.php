@php
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $subscriptions = $user ? $user->subscriptions : [];
    $orders = $user ? $user->orders : [];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-subheader title="{{__('My exam')}}"/>
    </x-slot>

</x-app-layout>
