<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create new product') }}
        </h2>
    </x-slot>
    <h1>Update: {{$post->title}}</h1>
    <form action="/posts/{{$ost->id}}" method="POST">
        @csrf
        @method("PUT")
        <p>
            <label for="post-name">
                Product name <br>
                <input type="text" id="post-name" name="post_name" value={{$post->post_name}}>
            </label>
            @error('post_name')
                <br>
                <small style="color:red">{{$message}}</small>
            @enderror

        </p>
        <p>
            <label for="price">
                Price <br>
                <input type="number" min="1.00" placeholder="post price" id="price" name="price" value={{$ost->price}}>
            </label>
            @error('price')
                <br>
                <small style="color:red">{{$message}}</small>
            @enderror
        </p>
        <button type="submit">Update</button>
    </form>
</x-app-layout>
