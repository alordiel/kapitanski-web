Creating a new product

<form action="/products" method="POST">
    @csrf
    <p>
        <label for="product-name">
            Product name <br>
            <input type="text" id="product-name" name="product_name" value={{old("product_name")}}>
        </label>
        @error('product_name')
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
    <button type="submit">Create</button>
</form>