<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class WishlistController extends Controller
{
    public function add(Request $request)
    {
        $user = Auth::user();

        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'User not authenticated.']);
        }

        $productId = $request->input('product_id');
        if (!$user->wishlist()->where('product_id', $productId)->exists()) {
            $user->wishlist()->create(['product_id' => $productId]);
            return response()->json(['status' => 'added', 'message' => 'Wishlist Added', 'redirect_url' => '/']);
        } else {
            $user->wishlist()->where('product_id', $productId)->delete();
            return response()->json(['status' => 'removed', 'message' => 'Wishlist Removed', 'redirect_url' => '/']);
        }
    }

    public function remove(Request $request)
    {
        $user = Auth::user();
        $productId = $request->input('product_id');

        // Remove the product from the wishlist
        $user->wishlist()->where('product_id', $productId)->delete();

         return response()->json(['status' => 'removed','message' => 'Wishlist Removed','redirect_url'=>'/']);
    }

    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())->get();
        $cartItems = Cart::where('user_id', Auth::id())->get();
        return view('wishlist', compact('wishlistItems', 'cartItems'));
    }
}
