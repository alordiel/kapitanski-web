<x-app-layout>
    <x-slot name="header">
        <x-subheader title="Create product" url="{{route('product.admin.manage')}}" icon="all" button-text="All products"/>
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
