<x-app-layout>
    <x-slot name="header">
        <x-subheader title="All Exams" icon="add" button-text="Add new" url="{{route('exam.admin.create')}}"/>
    </x-slot>

    @if(session()->has('message'))
        <x-success-message message="{{session('message')}}"/>
    @endif

    <ul>
        @foreach($orders as $order)
            <li class="flex">
                Order: #{{$order->id}} | Total: {{$order->total}} BGN | Credits: {{$order->credits}} |
                Status: {{$order->order_status}} |
                <a href="{{route('user.admin.show',['user'=>$order->user])}}">{{$order->user->name}}</a>
                <x-edit-entry url="{{route('order.edit',['order'=>$order])}}" title="Edit order"/>
                <x-delete-entry url="{{route('order.destroy',['order'=>$order])}}" entry="order"
                                button-title="Delete order"/>
            </li>
        @endforeach
    </ul>
</x-app-layout>
