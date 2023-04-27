<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create new product') }}
        </h2>
    </x-slot>
    <h1>Update: {{$product->product_name}}</h1>
    <form action="/products/{{$product->id}}" method="POST">
        @csrf
        @method("PUT")
        <p>
            <label for="product-name">
                Product name <br>
                <input type="text" id="product-name" name="product_name" value={{$product->product_name}}>
            </label>
            @error('product_name')
                <br>
                <small style="color:red">{{$message}}</small>
            @enderror

        </p>
        <p>
            <label for="price">
                Price <br>
                <input type="number" min="1.00" placeholder="product price" id="price" name="price" value={{$product->price}}>
            </label>
            @error('price')
                <br>
                <small style="color:red">{{$message}}</small>
            @enderror
        </p>
        <button type="submit">Update</button>
    </form>
</x-app-layout>
