<?php
namespace App\Http\Controllers;
use App\Events\OrderStatusChanged;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe;

class StripeController extends Controller
{
    /**
     * payment view
     */
    public function handleGet(Order $order)
    {
        return view('home', ['price' => $order->totalPrice(), 'order' =>$order]);
    }

    /**
     * handling payment with POST
     */
    public function handlePost(Request $request, Order $order)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
            "amount" => 100 * $order->totalPrice(),
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Making test payment."
        ]);
        Session::flash('success', 'Payment has been successfully processed.');
        $order->update(['status' => 'paid']);

        return back();
    }
}
