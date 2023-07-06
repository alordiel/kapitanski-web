<x-app-layout>
    <x-slot name="header">
        <x-subheader title="All Orders" icon="add" button-text="Add new" url="{{route('order.create')}}"/>
    </x-slot>

    @if(session()->has('message'))
        <x-success-message message="{{session('message')}}"/>
    @endif

    <ul>
        @foreach($takings as $taking)
            <li class="flex">
                Order: #{{$taking->id}} | Total: {{$taking->total}} BGN | Credits: {{$taking->credits}} |
                Status: {{$taking->order_status}} |
                <a href="{{route('user.admin.show',['user'=>$taking->user])}}">{{$taking->user->name}}</a>
                <x-edit-entry url="{{route('order.edit',['order'=>$taking])}}" title="Edit order"/>
                <x-delete-entry url="{{route('order.destroy',['order'=>$taking])}}" entry="order"
                                button-title="Delete order"/>
            </li>
        @endforeach
    </ul>
</x-app-layout>
