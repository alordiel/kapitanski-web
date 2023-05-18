<x-app-layout>
    <x-slot name="header">
        <x-subheader title="All Question categories" icon="add" button-text="Add new" url="{{route('questionCategory.create')}}"/>
    </x-slot>

    @if(session()->has('message'))
        <x-success-message message="{{session('message')}}"/>
    @endif

    <ul>
        @foreach($questionCategories as $questionCategory)
            <li>
                <a href="{{route('questionCategory.show',['questionCategory' => $questionCategory])}}" title="View">{{$questionCategory->name}} </a> |
                <x-edit-entry url="{{route('questionCategory.edit',['questionCategory'=>$questionCategory])}}" title="Edit category"/>
                <x-delete-entry url="{{route('questionCategory.destroy',['questionCategory'=>$questionCategory])}}" entry="category" button-title="Delete category"/>
            </li>
        @endforeach
    </ul>
</x-app-layout>
