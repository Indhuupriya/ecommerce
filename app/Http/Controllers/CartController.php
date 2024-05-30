<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);
      

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $request->product_id)
                    ->first();

        if ($cart) {
            $cart->quantity += $request->quantity;
        } else {
            $cart = new Cart([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        $cart->save();

        return redirect()->route('cart.show')->with('success', 'Product added to cart!');
    }

    public function showCart()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('cart', compact('cartItems'));
    }

   // app/Http/Controllers/CartController.php

public function updateCart(Request $request)
{
    $cart = Cart::where('user_id', Auth::id())
                ->where('product_id', $request->id)
                ->first();

    if ($cart) {
        $cart->quantity = $request->quantity;
        $cart->save();
        return response()->json(['success' => true, 'message' => 'Cart updated successfully!']);
    }

    return response()->json(['success' => false, 'message' => 'Cart item not found.']);
}

public function removeCart(Request $request)
{
    $cart = Cart::where('user_id', Auth::id())
                ->where('product_id', $request->id)
                ->first();

    if ($cart) {
        $cart->delete();
        return response()->json(['success' => true, 'message' => 'Product removed from cart successfully!']);
    }

    return response()->json(['success' => false, 'message' => 'Cart item not found.']);
}

}

?>