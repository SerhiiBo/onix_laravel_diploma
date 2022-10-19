<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PaymentController extends Controller
{
    public function pay(Request $request, Order $order)
    {
        $this->authorize('pay-order', $order);

        $user = auth()->user();
        $stripeCharge = auth()->user()->charge(
            $order->totalPrice(), $request->paymentMethodId
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
