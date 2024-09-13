<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    use ApiResponse;
    public function index() {
        // View all orders
        return $this->successResponse(data:Order::with("user:id,name")->paginate(10));
    }

    public function updateStatus(Request $request, $order) {
        // Update order status (e.g., shipped, delivered, canceled)
    }


    public function destroy($order) {
        // Cancel an order

        $order=Order::find($order);
        $order->delete();
        return $this->successResponse(message:"order deleted succesfully");
    }
}
