Creating a new post
<x-layout>
    <h1>Create new post</h1>
    <form action="/posts" method="POST">
        @csrf
        <p>
            <label for="post-name">
                Product name <br>
                <input type="text" id="post-name" name="post_name" value={{old("post_name")}}>
            </label>
            @error('post_name')
            <br>
            <small style="color:red">{{$message}}</small>
            @enderror

        </p>
        <p>
            <label for="price">
                Price <br>
                <input type="number" min="1.00" placeholder="post price" id="price" name="price" value={{old("price")}}>
            </label>
            @error('price')
            <br>
            <small style="color:red">{{$message}}</small>
            @enderror
        </p>
        <button type="submit">Create</button>
        <input type="hidden" value="0" name="post_order">
        <input type="hidden" value="Product description" name="description">
        <input type="hidden" value="1" name="number_of_credits">
    </form>
</x-layout>
