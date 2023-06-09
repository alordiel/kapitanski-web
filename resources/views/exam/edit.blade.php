<x-app-layout>
    <x-slot name="header">
            <x-subheader title="Edit Exam" icon="all" button-text="All exams" url="{{route('exam.admin.manage')}}"/>
    </x-slot>

    @if(session()->has('message'))
        <x-success-message message="{{session('message')}}"/>
    @endif

    <form action="{{route('exam.admin.update', ['exam'=> $exam])}}" method="POST">
        @csrf
        @method('PUT')
        <p class="mb-3">
            <x-input-label for="name" :value="__('Product name')"/>
            <x-text-input
                type="text"
                id="name"
                name="name"
                class="w-1/4 block"
                :value="$exam->name"
            />
            @error('name')
            <x-input-error :messages="$message" class="mt-2"/>
            @enderror

        </p>
        <x-primary-button> Update </x-primary-button>
    </form>
</x-app-layout>
