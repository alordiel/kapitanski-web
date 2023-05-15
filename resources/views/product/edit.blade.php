<x-app-layout>
    <x-slot name="header">
        <x-subheader title="Edit product" url="{{route('product.admin.manage')}}" icon="all" button-text="All products"/>
    </x-slot>
    <div>
        @if(session()->has('message'))
            <x-success-message message="{{session('message')}}"/>
        @endif
    </div>
    <form action="/admin/products/{{$product->id}}" method="POST">
        @csrf
        @method('PUT')
        <p class="mb-3">
            <x-input-label for="name" :value="__('Product name')"/>
            <x-text-input
                class="block w-1/5"
                id="name"
                name="name"
                required
                :value="$product->name"
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
                :value="$product->price"
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
                :value="$product->credits"
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
                {{$product->description}}
            </textarea>
            @error('description')
            <x-input-error :messages="$message" class="mt-2"/>
            @enderror
        </p>
        <x-primary-button>Update</x-primary-button>
    </form>
</x-app-layout>
