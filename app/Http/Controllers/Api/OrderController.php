<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index()
    {
        $order = Order::where('user_id', Auth::id())->get();
        return $order;
    }

    public function show(Order $order)
    {
        return $order;
    }

    public function store(Request $request): Order
    {
        $order = new Order();
        $user = Auth::user();
        $order->create($user, $order, $request);
        return $order;
    }

    public function update(Request $request, Order $order)
    {
        $request->whenFilled('comment', function ($comment) use ($order) {
            $order->update(['comment' => $comment]);
        });

        return $order;
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
