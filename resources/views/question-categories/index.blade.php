<x-app-layout>
    <x-slot name="header">
        <x-subheader title="All Question categories" icon="add" button-text="Add new" url="{{route('question_category.create')}}"/>
    </x-slot>

    @if(session()->has('message'))
        <x-success-message message="{{session('message')}}"/>
    @endif

    <ul>
        @foreach($questionCategories as $questionCategory)
            <li>
                <a href="{{route('question_category.show',['questionCategory' => $questionCategory])}}" title="View">{{$questionCategory->name}} </a> |
                <x-edit-entry url="{{route('question_category.edit',['questionCategory'=>$questionCategory])}}" title="Edit category"/>
                <x-delete-entry url="{{route('question_category.destroy',['questionCategory'=>$questionCategory])}}" entry="category" button-title="Delete category"/>
            </li>
        @endforeach
    </ul>
</x-app-layout>
