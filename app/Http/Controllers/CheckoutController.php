<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\User;
use App\Models\BillingAddress;
use Illuminate\Support\Facades\DB;
use Stripe;
use Session;
use Stripe\Charge;
use PDF;
class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $subtotal = $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->product->price;
        });
        $shipping = 0.00; 
        $tax = 0;
        $total = $subtotal + $shipping + $tax;
		//checking
			
        return view('checkout', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    public function saveAddress(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:10',
        ]);

        $billingAddress = new BillingAddress();
        $billingAddress->user_id = Auth::id();
        $billingAddress->firstname = $request->firstname;
        $billingAddress->email = $request->email;
        $billingAddress->address = $request->address;
        $billingAddress->city = $request->city;
        $billingAddress->state = $request->state;
        $billingAddress->zip = $request->zip;
        $billingAddress->save();

        return redirect()->route('checkout.payment');
    }

    public function showPaymentPage()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $subtotal = $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->product->price;
        });
        $shipping = 0.00;
        $tax = 0;
        $total = $subtotal + $shipping + $tax;

        return view('payment', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }
    public function processPayment(Request $request)
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.show')->with('error', 'Your cart is empty.');
        }
        $payment_method = $request->payment_method;
        $cartItems = Cart::where('user_id', Auth::id())->get();
        if ($request->payment_method == 'stripe') {
            return view('stripe')->with(['payment_method'=>$payment_method,'cartItems'=>$cartItems]);
        } elseif ($request->payment_method == 'paypal') {
            // return view('paypal')->with(['payment_method'=>$payment_method]);
            return redirect()->route('paypal.payment');
        }
    }
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $billingAddress = BillingAddress::where('user_id', Auth::id())->get();
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $totalAmount = $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->product->price;
        });
        $customer = Stripe\Customer::create([
            "address" => [
                "line1" => $billingAddress[0]['address'],
                "postal_code" => $billingAddress[0]['zip'],
                "city" => $billingAddress[0]['city'],
                "state" => $billingAddress[0]['state'],
                "country" => "IN", 
            ],
            "email" => $billingAddress[0]['email'],
            "name" => $billingAddress[0]['firstname'],
            "source" => $request->stripeToken 
        ]);
        $charge = Stripe\Charge::create([
            "amount" => $totalAmount * 100, 
            "currency" => "usd",
            "customer" => $customer->id,
            "description" => "Payment for products",
            "shipping" => [
                "name" => $billingAddress[0]['firstname'],
                "address" => [
                    "line1" => $billingAddress[0]['address'],
                    "postal_code" => $billingAddress[0]['zip'],
                    "city" => $billingAddress[0]['city'],
                    "state" => $billingAddress[0]['state'],
                    "country" => "IN", 
                ],
            ],
        ]);
        $payment_method = $request->payment_method;
        $tnx_id = $charge->id;
        $order = Order::create([
            'user_id' => Auth::id(),
            'payment_status' => 'completed', 
            'payment_type' => $payment_method,
            'order_status' => 'pending', 
            'total' => $totalAmount,
            'tnx_id' => $tnx_id,
        ]);
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);
        }
        Cart::where('user_id', Auth::id())->delete();
        Session::flash('success', 'Payment successful!');
        return redirect()->route('cart.show');
    }

    public function downloadInvoice(Order $order)
    {
        $billingAddress = BillingAddress::where('user_id', $order->user_id)->first();
        $user = User::where('id', $order->user_id)->first();
        // $items = OrderItem::where('user_id',$order->user_id)->first(); 
    
        $data = [
            'order' => $order,
            'billing_address' => $billingAddress,
            'user' => $user,
            'items' => $order->orderItems,
        ];
        $pdf = PDF::loadView('invoice', $data);
    
        return $pdf->download('invoice.pdf');
    }
    
    
}


?>