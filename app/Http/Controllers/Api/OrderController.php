<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Order::class, 'order');
    }

    public function index()
    {
        if (request()->user()->isUser()){
            $order = Order::where('user_id', Auth::id())->get();
        } else {
            $order = Order::paginate(10);
        }
        return $order;
    }

    public function show(Order $order)
    {
        $query = $order->with('order_items')
            ->find($order->id);
        return $query;
    }

    public function store(Request $request): Order
    {
        $order = new Order();
        $order->create($order, $request);
        return $order;
    }

    public function update(Request $request, Order $order)
    {
        $request->whenFilled('comment', function ($comment) use ($order) {
            $order->update(['comment' => $comment]);
        });


        if (auth()->user()->isAdmin() ) {
            $request->whenFilled('status', function ($status) use ($order) {
                $order->update(['status' => $status]);
            });
        }
        return $order;
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
