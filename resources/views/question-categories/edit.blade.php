<x-app-layout>
    <x-slot name="header">
            <x-subheader title="Edit category" icon="all" button-text="All question categories" url="{{route('question_category.manage')}}"/>
    </x-slot>

    @if(session()->has('message'))
        <x-success-message message="{{session('message')}}"/>
    @endif

    <form action="{{route('question_category.update', ['questionCategory'=> $question_category])}}" method="POST">
        @csrf
        @method('PUT')
        <p class="mb-3">
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input
                type="text"
                id="name"
                name="name"
                class="w-1/4 block"
                :value="$question_category->name"
            />
            @error('name')
            <x-input-error :messages="$message" class="mt-2"/>
            @enderror

        </p>
        <p class="mb-3">
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input
                type="text"
                id="name"
                name="name"
                class="w-1/4 block"
                :value="$question_category->name"
            />
            @error('name')
            <x-input-error :messages="$message" class="mt-2"/>
            @enderror

        </p>
        <x-primary-button> Update </x-primary-button>
    </form>
</x-app-layout>
