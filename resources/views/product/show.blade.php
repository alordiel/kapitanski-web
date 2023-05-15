<x-app-layout>
    <x-slot name="header">
        <x-subheader title="{{$product->name}}" url="{{route('product.admin.manage')}}" icon="all"
                     button-text="All products"/>
    </x-slot>

    <h1>{{$product->name}}</h1>
    <small>Price: {{$product->price}}</small>

    <x-edit-entry url="{{route('product.admin.edit',['product' => $product])}}" title="Edit product"/>
    <x-delete-entry url="{{route('product.admin.destroy',['product' => $product])}}"
                    button-title="Delete product" entry="product"/>
</x-app-layout>
