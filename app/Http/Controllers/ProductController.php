<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(5);
        return view('product', ['products' => $products]);
    }
    public function create()
    {
        return view ('addproduct');
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'images.*' => 'required'
        ]);
        // Store product data
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public'); 
            }
        }
        $product = Product::create([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'description' => $validatedData['description'],
            'images'=>$path
        ]);
        session()->flash('success', 'Product Created Successfully.');
        return redirect()->route('admin.products');
    }
    public function edit($id)
    {
        $product = Product::find($id);
        return view('editproduct', ['product' => $product]);
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,webp,jpg,gif|max:2048'
        ]);
        $product = Product::find($id);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images = $path;
            }
        }
        elseif ($request->filled('old_images')) {
            $product->images = $request->old_images;
        }
        $product->save();
        session()->flash('success', 'Product Updated Successfully.');
        return redirect()->route('admin.products');
    }
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        session()->flash('success', 'Product Deleted Successfully.');
        return redirect()->route('admin.products');
    }
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product.show', compact('product'));
    }
   

}
