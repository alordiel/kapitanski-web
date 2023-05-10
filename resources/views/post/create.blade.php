<x-app-layout>
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('New posts') }}
            </h2>
            <a
                href="/admin/posts"
                class="flex items-center justify-between rounded bg-primary px-6 pb-2 pt-2.5 text-base font-bold text-white transition duration-150 ease-in-out hover:bg-primary-600  focus:bg-primary-600  focus:outline-none focus:ring-0 active:bg-primary-700 ">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em"
                     width="1em" xmlns="http://www.w3.org/2000/svg">
                    <path fill="none" d="M0 0h24v24H0z"></path>
                    <path d="M11.67 3.87L9.9 2.1 0 12l9.9 9.9 1.77-1.77L3.54 12z"></path>
                </svg>
                All Posts
            </a>
        </div>
    </x-slot>
    <form action="/admin/posts" method="POST">
        @csrf
        <p>
            <x-input-label for="title" :value="__('Post title')"/>
            <x-text-input class="block w-1/5" id="title" name="title" required value="{{old('title')}}" type="text"/>
            @error('title')
            <x-input-error :messages="$message" class="mt-2"/>
            @enderror

        </p>
        <p>
            <x-input-label for="slug" :value="__('Post slug')"/>
            <x-text-input class="block w-1/5" type="text" id="slug" name="slug" required value="{{old('slug')}}"/>
            @error('slug')
            <x-input-error :messages="$message" class="mt-2"/>
            @enderror
        </p>
        <div style="max-width: 800px" class="my-5">
            <label for="editor">Post content</label><br>
            <div class="text-black">
                <textarea id="editor" name="content" rows="10"></textarea>
            </div>
            @error('content')
            <x-input-error :messages="$message" class="mt-2"/>
            @enderror
        </div>
        <script>
            ClassicEditor
                .create(document.querySelector('#editor'), {})
                .then(editor => {
                    editor.editing.view.change(writer => {
                        writer.setStyle('height', '400px', editor.editing.view.document.getRoot());
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
        <x-primary-button>Create</x-primary-button>
        <input type="hidden" value="0" name="featured_image">
        <input type="hidden" value="Product description" name="excerpt">
    </form>
</x-app-layout>
