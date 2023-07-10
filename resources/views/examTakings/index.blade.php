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
                ID: #{{$taking->id}} | User: {{$taking->user->name}} | Score: {{$taking->score}} |
                Date: {{$taking->created_at}} |
                <a href="{{route('user.admin.show',['user'=>$taking->user])}}">{{$taking->user->name}}</a>
                <x-edit-entry url="{{route('examTaking.edit',['taking'=>$taking])}}" title="View taking"/>
                <x-delete-entry url="{{route('examTaking.destroy',['taking'=>$taking])}}" entry="taking"
                                button-title="Delete taking"/>
            </li>
        @endforeach
    </ul>
</x-app-layout>
