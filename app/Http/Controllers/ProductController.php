<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Product;
use Validator;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('product.index', [
            'products' => Product::all()
        ]);
    }

    public function create(): View
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', 'unique:products'],
            'price' => ['required','min:1','decimal:2'],
            'credits' => ['required','numeric', 'unique:products'],
            'description' => 'required',
        ]);

        Product::create($formFields);

        return redirect('/admin/products')->with('message', 'Product successfully created');
    }

    public function show(Product $product): View
    {
        return view('product.show', ['product' => $product]);
    }

    public function edit(Product $product): View
    {
        return view('product.edit', ['product' => $product]);
    }

    public function update(Request $request, Product $product)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'price' => ['required'],
            'description' => 'required',
            'credits' => 'required',
        ]);

        $product->update($formFields);

        return back()->with('message', 'Product updated successfully!');
    }

    public function destroy(Product $product) {
        $product->delete();
        return redirect('/admin/products')->with('message','Deleted successfully');
    }
}
