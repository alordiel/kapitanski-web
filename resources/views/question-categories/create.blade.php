<x-app-layout>
    <x-slot name="header">
        <x-subheader title="Add new question category" icon="all" button-text="All question categories" url="{{route('question_category.manage')}}"/>
    </x-slot>

    <form action="{{route('question_category.store')}}" method="POST">
        @csrf
        <p class="mb-3">
            <x-input-label for="name" :value="__('Category name')" />
            <x-text-input
                type="text"
                id="name"
                name="name"
                class="w-1/4 block"
                value="{{old('name')}}"
            />
            @error('name')
            <x-input-error :messages="$message" class="mt-2"/>
            @enderror

        </p>
        <p class="mb-3">
            <x-input-label for="slug" :value="__('Slug')" />
            <x-text-input
                type="text"
                id="slug"
                name="slug"
                class="w-1/4 block"
                value="{{old('slug')}}"
            />
            @error('slug')
            <x-input-error :messages="$message" class="mt-2"/>
            @enderror

        </p>
        <x-primary-button> Create </x-primary-button>
    </form>
</x-app-layout>
