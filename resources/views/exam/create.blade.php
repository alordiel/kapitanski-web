<x-app-layout>
    <x-slot name="header">
        <x-subheader title="Add new exam" icon="all" button-text="All exams" url="{{route('exam.admin.manage')}}"/>
    </x-slot>
    <form action="{{route('exam.admin.store')}}" method="POST">
        @csrf
        <p class="mb-3">
            <x-input-label for="name" :value="__('Product name')" />
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
        <x-primary-button> Create </x-primary-button>
    </form>
</x-app-layout>
