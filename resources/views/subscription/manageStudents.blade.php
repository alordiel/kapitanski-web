@php
    use \App\Models\Subscription;
    use Illuminate\Support\Facades\Auth;
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-subheader title="{{__('Manage subscriptions')}}"/>
    </x-slot>

    @if(session()->has('message'))
        <x-success-message message="{{session('message')}}"/>
    @endif

</x-app-layout>
