<x-app-layout>
    <x-slot name="header">
         <x-subheader title="{{$exam->name}}" icon="all" button-text="All exams" url="{{route('exam.index')}}"/>
    </x-slot>
    <small>Price: {{$exam->price}}</small>
    <span class="edit">
        <a href="/exams/{{$exam->id}}/edit" title="edit">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0z"></path><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 5.63l-2.34-2.34a.996.996 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83a.996.996 0 000-1.41z"></path></svg>
        </a>
    </span>
</x-app-layout>
