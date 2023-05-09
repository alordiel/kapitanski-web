<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create new product') }}
        </h2>
    </x-slot>
    <h1>Create new product</h1>
    <form action="/products" method="POST">
        @csrf
        <p>
            <label for="name">
                Product name <br>
                <input type="text" id="name" name="name" value={{old("name")}}>
            </label>
            @error('name')
            <br>
            <small style="color:red">{{$message}}</small>
            @enderror
        </p>
        <p>
            <label for="price">
                Price <br>
                <input type="number" min="1.00" placeholder="product price" id="price" name="price" value={{old("price")}}>
            </label>
            @error('price')
            <br>
            <small style="color:red">{{$message}}</small>
            @enderror
        </p>
        <p>
            <label for="credits">
                Number of credits <br>
                <input type="number" min="1" id="credits" name="credits" value={{old("credits")}}>
            </label>
            @error('credits')
            <br>
            <small style="color:red">{{$message}}</small>
            @enderror
        </p>
        <p>
            <label for="description">
                Product description <br>
                <textarea id="description" name="description" rows="4" cols="50"></textarea>
            </label>
        </p>
        <x-primary-button>Create</x-primary-button>
    </form>
</x-app-layout>
