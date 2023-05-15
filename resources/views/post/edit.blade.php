<x-app-layout>
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>

    <x-slot name="header">
       <x-subheader title="Edit post" url="{{route('post.admin.manage')}}" icon="all" button-text="All posts"/>
    </x-slot>

    @if(session()->has('message'))
        <x-success-message message="{{session('message')}}"/>
    @endif

    <form action="/admin/posts/{{$post->id}}" method="POST">
        @csrf
        @method("PUT")
        <p>
            <x-input-label for="title" :value="__('Post title')"/>
            <x-text-input
                class="block w-1/5"
                id="title"
                name="title"
                required
                :value="$post->title"
                type="text"
            />
            @error('title')
            <x-input-error :messages="$message" class="mt-2"/>
            @enderror

        </p>
        <p>
            <x-input-label for="slug" :value="__('Post slug')"/>
            <x-text-input
                class="block w-1/5"
                type="text"
                id="slug"
                name="slug"
                required
                :value="$post->slug"
            />
            @error('slug')
            <x-input-error :messages="$message" class="mt-2"/>
            @enderror
        </p>
        <div style="max-width: 800px" class="my-5">
            <label for="editor">Post content</label><br>
            <div class="text-black">
                <textarea id="editor" name="content">{{$post->content}}</textarea>
            </div>
            @error('content')
            <x-input-error :messages="$message" class="mt-2"/>
            @enderror
        </div>

        <script>
            ClassicEditor
                .create(document.querySelector('#editor'), {
                    height: 600
                })
                .then(editor => {
                    editor.editing.view.change(writer => {
                        writer.setStyle('height', '400px', editor.editing.view.document.getRoot());
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        </script>

        <x-primary-button>Update</x-primary-button>
        <input type="hidden" value="0" name="featured_image">
        <input type="hidden" value="" name="excerpt">
    </form>
</x-app-layout>
