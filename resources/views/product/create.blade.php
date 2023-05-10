<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('New Product') }}
            </h2>
            <a
                href="/admin/products"
                class="flex items-center justify-between rounded bg-primary px-6 pb-2 pt-2.5 text-base font-bold text-white transition duration-150 ease-in-out hover:bg-primary-600  focus:bg-primary-600  focus:outline-none focus:ring-0 active:bg-primary-700 ">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em"
                     width="1em" xmlns="http://www.w3.org/2000/svg">
                    <path fill="none" d="M0 0h24v24H0z"></path>
                    <path d="M11.67 3.87L9.9 2.1 0 12l9.9 9.9 1.77-1.77L3.54 12z"></path>
                </svg>
                All Products
            </a>
        </div>
    </x-slot>
    <form action="/admin/products" method="POST">
        @csrf
        <p class="mb-3">
            <x-input-label for="name" :value="__('Product name')"/>
            <x-text-input
                class="block w-1/5"
                id="name"
                name="name"
                required
                value="{{old('name')}}"
                type="text"
            />
            @error('name')
            <x-input-error :messages="$message" class="mt-2"/>
            @enderror
        </p>
        <p class="mb-3">
            <x-input-label for="price" :value="__('Price')"/>
            <x-text-input
                type="number"
                id="price"
                name="price"
                value="{{old('price')}}"
                class="block w-20"
                min="1"
                required
            />
            @error('price')
            <x-input-error :messages="$message" class="mt-2"/>
            @enderror
        </p>
        <p class="mb-3">
            <x-input-label for="credits" :value="__('Credits')"/>
            <x-text-input
                type="number"
                id="credits"
                name="credits"
                value="{{old('credits')}}"
                class="block w-20"
                min="1"
                required
            />
            @error('credits')
            <x-input-error :messages="$message" class="mt-2"/>
            @enderror
        </p>
        <p class="mb-3">
            <x-input-label for="description" :value="__('Product description')"/>
            <textarea
                id="description"
                name="description"
                rows="4"
                cols="30"
                class="text-black"
            >
                {{old('description')}}
            </textarea>
            @error('description')
            <x-input-error :messages="$message" class="mt-2"/>
            @enderror
        </p>
        <x-primary-button>Create</x-primary-button>
    </form>
</x-app-layout>
