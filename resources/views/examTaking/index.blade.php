<x-app-layout>
    <x-slot name="header">
        <x-subheader title="All Orders" icon="add" button-text="Add new" url="{{route('order.create')}}"/>
    </x-slot>

    @if(session()->has('message'))
        <x-success-message message="{{session('message')}}"/>
    @endif

    <ul>
        @foreach($examTakings as $taking)
            <li class="flex">
                ID: #{{$taking->id}} | User: {{$taking->user->name}} | Type: {{$taking->exam_type}} | Score: {{$taking->result}}% |
                Date: {{$taking->created_at}} |
                <a href="{{route('user.admin.show',['user'=>$taking->user])}}">{{$taking->user->name}}</a>
                <x-edit-entry url="{{route('examTaking.show',['examTaking'=>$taking])}}" title="View taking"/>
                <x-delete-entry url="{{route('examTaking.destroy',['examTaking'=>$taking])}}" entry="taking"
                                button-title="Delete taking"/>
            </li>
        @endforeach
    </ul>
</x-app-layout>
