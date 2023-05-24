<x-app-layout>
    <x-slot name="header">
        <x-subheader title="All Subscriptions" icon="add" button-text="Add new" url="{{route('subscription.create')}}"/>
    </x-slot>

    @if(session()->has('message'))
        <x-success-message message="{{session('message')}}"/>
    @endif

    <ul>
        @foreach($subscriptions as $subscription)
            <li class="flex">
                Order: #{{$subscription->order_id}} | Exam: {{$subscription->exam->name}} |
                Started on: {{date('d-m-Y', strtotime($subscription->created_at))}} |
                Expires on: {{date('d-m-Y', strtotime($subscription->expires_on))}} |
                By: <a href="{{route('user.admin.show',['user'=>$subscription->user])}}">{{$subscription->user->name}}</a>
                <x-edit-entry url="{{route('subscription.edit',['subscription'=>$subscription])}}" title="Edit subscription"/>
                <x-delete-entry url="{{route('subscription.destroy',['subscription'=>$subscription])}}" entry="subscription"
                                button-title="Delete subscription"/>
            </li>
        @endforeach
    </ul>
</x-app-layout>
