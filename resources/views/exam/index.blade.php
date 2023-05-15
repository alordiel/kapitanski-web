<x-app-layout>
    <x-slot name="header">
        <x-subheader title="All Exams" icon="add" button-text="Add new" url="{{route('exam.admin.create')}}"/>
    </x-slot>

    @if(session()->has('message'))
        <x-success-message message="{{session('message')}}"/>
    @endif

    <ul>
        @foreach($exams as $exam)
            <li>
                <a href="{{route('exam.admin.show',['exam' => $exam])}}" title="View">{{$exam->name}} </a> |
                <a href="{{route('exam.admin.questions', ['exam'=>$exam])}}" title="Manage Questions">Manage questions</a>
                <x-edit-entry url="{{route('exam.admin.edit',['exam'=>$exam])}}" title="Edit exam"/>
                <x-delete-entry url="{{route('exam.admin.destroy',['exam'=>$exam])}}" entry="exam" button-title="Delete exam"/>
            </li>
        @endforeach
    </ul>
</x-app-layout>
