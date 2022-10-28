<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PaymentController extends Controller
{
    public function pay(Request $request, Order $order)
    {
        $this->authorize('pay-order', $order);

        $priceToPay=$order->totalPrice()*100;
//        $user = auth()->user();
        $user = User::where('id', $order->user_id)->first();

        $user->createOrGetStripeCustomer();

        $stripeCharge = $user->charge(
            $priceToPay, 'card'
        );

        $payment = Payment::create([
            'payment_method' => 'stripe',
            'payment_details' => $stripeCharge->jsonSerialize(),
            'user_id' => $user->id,
            'order_id' => $order->id,
            'status' => $stripeCharge->status,
        ]);


        if ($payment->status == 'succeeded') {
            $order->update(['status' => 'paid']);
        }
    }

}
