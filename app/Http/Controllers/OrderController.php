<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\BillingAddress;
use App\Models\User;
class OrderController extends Controller
{
   public function index(){
        $orders = Order::paginate(5);
        return view('vieworders', ['orders' => $orders]);
   }
   public function showInvoice($id)
    {
        $order = Order::findOrFail($id);
        $billing_address = BillingAddress::where('user_id', $order->user_id)->first();
        $user = User::where('id', $order->user_id)->first();
        return view('invoice', ['order' => $order,'billing_address'=>$billing_address,'items' => $order->orderItems,'user' => $user,]);
    }
    public function updateStatus(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        if ($order->order_status === 'completed') {
            return response()->json(['error' => 'Order status is already completed.',400]);
        }
        $order->update(['order_status' => $request->status]);
        return response()->json(['success' => 'Order status updated successfully.', 'redirect_url' => route('admin.orders')]);

    }
}
