<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Validator;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index', [
            'products' => Product::all()
        ]);
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'product_name' => 'required',
            'price' => ['required', 'numeric']
        ]);

        Product::create($formFields);

        return redirect('/products')->with('message', 'Product successfully created');
    }

    public function show(Product $product)
    {
        return view('product.show', ['product' => $product]);
    }

    public function edit(Product $product)
    {
        return view('product.edit', ['product' => $product]);
    }

    public function update(Request $request, Product $product)
    {
        $formFields = $request->validate([
            'product_name' => 'required',
            'price' => ['required'],
        ]);

        $product->update($formFields);

        return back()->with('message', 'Product updated successfully!');
    }

    public function destroy(Product $product) {
        $product->delete();
        return redirect('/products')->with('message','Deleted successfully');
    }
}
