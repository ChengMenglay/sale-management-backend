<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
    public function index(){
        $orders= Order::orderBy('created_at',"desc")->get();

        return OrderResource::collection($orders);
    }
    public function store(StoreOrderRequest $request){
        $validated = $request->validated();

        try {
            $user = User::find($validated['user_id']); // Eloquent version
            // $user = DB::table('users')->where('id', $validated['user_id'])->first(); // Query Builder version

            if (!$user) {
                return response()->json([
                    'message' => 'User not found!'
                ], 404);
            }
            
            $order = Order::create([
                'user_id' => $user->id,
                'discount' => $validated['discount'] ?? 0,
                'note' => $validated['note'] ?? "",
                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated["payment_status"],
                'order_status' => $validated["order_status"],
                'amount_paid' => $validated['amount_paid'],
                'total' =>  $validated['total'],
            ]);

            return response()->json([
                "message" => "Order created and payment successful.",
                "data" => new OrderResource($order)
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                "message" => "Something went wrong!",
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function destroy($id){
        $order= Order::findOrFail($id);
        $order->delete();
        return response()->json(["message"=>"Order delete successfully!"],200);
    }

}
