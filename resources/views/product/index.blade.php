List of products:
@if(session()->has('message'))
    <p style='color:green'>{{session('message')}}</p>
@endif;
@foreach($products as $product)
    {{$product->product_name}}
@endforeach 