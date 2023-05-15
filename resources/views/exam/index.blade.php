<x-app-layout>
    <x-slot name="header">
        <x-subheader title="All Exams" icon="add" button-text="Add new" url="{{route('exam.admin.create')}}"/>
    </x-slot>

    @if(session()->has('message'))
        <p style='color:green'>{{session('message')}}</p>
    @endif
    <ul>
        @foreach($exams as $exam)
            <li>
                <a href="{{route('exam.admin.show',['exam' => $exam])}}" title="View">{{$exam->name}} </a> |
                <x-edit-entry url="{{route('exam.admin.edit',['exam'=>$exam])}}" title="Edit exam"/>
                <x-delete-entry url="{{route('exam.admin.destroy',['exam'=>$exam])}}" entry="exam" button-title="Delete exam"/>
            </li>
        @endforeach
    </ul>
</x-app-layout>
