<x-app-layout>
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create new post') }}
        </h2>
    </x-slot>
    <form action="/posts" method="POST">
        @csrf
        <p>
            <x-input-label for="title" :value="__('Post title')"/>
            <x-text-input class="block w-1/5" id="title" name="title" required value="{{old('title')}}"  type="text" />
            @error('title')
            <x-input-error :messages="$message" class="mt-2"/>
            @enderror

        </p>
        <p>
            <x-input-label for="slug" :value="__('Post slug')"/>
            <x-text-input class="block w-1/5" type="text" id="slug" name="slug" required value="{{old('slug')}}" />
            @error('slug')
            <x-input-error :messages="$message" class="mt-2"/>
            @enderror
        </p>
        <div style="max-width: 800px" class="my-5">
            <label for="editor">Post content</label><br>
            <div class="text-black">
                <textarea id="editor" name="content"></textarea>
            </div>
        </div>
        <script>
            ClassicEditor
                .create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
                });
        </script>
        <x-primary-button>Create</x-primary-button>
        <input type="hidden" value="0" name="featured_image">
        <input type="hidden" value="Product description" name="excerpt">
    </form>
</x-app-layout>
