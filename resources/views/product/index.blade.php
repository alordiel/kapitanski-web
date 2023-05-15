<x-app-layout>
    <x-slot name="header">
        <x-subheader title="All Products" url="{{route('product.admin.create')}}" icon="add" button-text="Add product"/>
    </x-slot>

    @if(session()->has('message'))
        <x-success-message message="{{session('message')}}"/>
    @endif

    <ul class="list-of-products">
        @foreach($products as $product)
            <li>
            <span class="product-name">
                <a href="{{route('product.admin.show',['product' => $product])}}" title="View">{{$product->name}} </a>
            </span>
                <span class="price">{{$product->price}} лв.</span>
                <span>{{$product->credits}} кредита</span>
                <div>
                    <x-edit-entry url="{{route('product.admin.edit',['product' => $product])}}" title="Edit product"/>
                    <x-delete-entry url="{{route('product.admin.destroy',['product' => $product])}}"
                                    button-title="Delete product" entry="product"/>
                </div>
            </li>
        @endforeach
    </ul>
</x-app-layout>
