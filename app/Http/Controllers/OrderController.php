<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;


class OrderController extends Controller
{
    public function index() {
        return Order::with('items.product','client','delivery')->get();
    }

    public function store(Request $request) {
        $request->validate([
            'items'=>'required|array',
            'items.*.product_id'=>'required|exists:products,id',
            'items.*.quantity'=>'required|integer|min:1'
        ]);

        $order = Order::create(['user_id'=>auth()->id(),'status'=>'pending']);

        foreach ($request->items as $item) {
            $order->items()->create([
                'product_id'=>$item['product_id'],
                'quantity'=>$item['quantity'],
                'price'=>Product::find($item['product_id'])->price
            ]);
        }

        return response()->json($order->load('items.product'),201);
    }

    public function updateStatus(Request $request, Order $order) {
        $request->validate(['status'=>'required|in:pending,in_progress,delivered']);
        $order->update(['status'=>$request->status]);
        return response()->json($order);
    }
}
