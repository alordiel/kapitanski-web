<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        return view('product.index', [
            'products' => Product::all()
        ]);
    }

    public function create() {
        return view('product.create');
    }
}
