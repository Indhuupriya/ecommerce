<?php

namespace App\Http\Controllers;
use App\Models\UserProfile;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
class UserProfiles extends Controller
{
    public function index(){
        $user_id = Auth::id();
        $get_profile= UserProfile::where('user_id',$user_id)->first();
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $orders = Order::where('user_id', Auth::id())->get();
        return view('myprofile')->with([Auth::user(),'address_one'=>$get_profile,'cartItems'=>$cartItems,'orders'=>$orders]);
    }
    public function update(Request $request)
    {
        $user_id = $request->id;
        $user = User::find($user_id);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'profile_image' => 'file|max:2048'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->hasFile('profile_image')) {
            $request->validate([
                'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            $image = $request->file('profile_image');
            $filename = 'profile_image_'.time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('public')->put('profile_image/' . $filename, file_get_contents($image));
            $user->profile_image = $filename;
        }
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->save();
        return redirect()->back()->with('success', 'Profile updated successfully');
    }
    public function change_password(){
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $orders = Order::where('user_id', Auth::id())->get();
        return view('myprofile')->with(['cartItems'=>$cartItems,'orders'=>$orders]);
    }
    public function update_password(Request $request){
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $user = $request->user();
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages(['current_password' => 'The provided password does not match your current password.']);
        }
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('myaccount')->with('success', 'Password changed successfully.');
    }
    public function add_new_address(){
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $orders = Order::where('user_id', Auth::id())->get();
        return view('myprofile')->with(['cartItems'=>$cartItems,'orders'=>$orders]);
    }
    public function add_address(Request $request){
        $validator = Validator::make($request->all(), [
            'address' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user_id = $request->user_id;
        $address = UserProfile::where('user_id',$user_id)->first();
        if ($address) {
            $address->address = $request->address;
            $address->save();
            return redirect()->route('myaccount')->with('success', 'Profile updated successfully');
        } else {
            return redirect()->route('myaccount')->with('error', 'User profile not found');
        }
    }
}
