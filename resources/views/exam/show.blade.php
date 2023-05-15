<x-app-layout>
    <x-slot name="header">
        <x-subheader title="{{$exam->name}}" icon="all" button-text="All exams" url="{{route('exam.admin.manage')}}"/>
    </x-slot>
    <small>Price: {{$exam->price}}</small>
    <x-edit-entry url="{{route('exam.admin.edit',['exam'=>$exam])}}" title="Edit exam" />
</x-app-layout>
