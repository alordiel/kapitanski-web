Creating a new product

<form action="" method="POST">
    @csrf
    <p>
        <label for="product-name">
            Product name <br>
            <input type="text" id="product-name" name="product_name">
        </label>
    </p>
    <p>
        <label for="price">
            Price <br>
            <input type="number" min="1.00" placeholder="product price" id="price" name="price">
        </label>
    </p>
    <button type="submit">Create</button>
</form>