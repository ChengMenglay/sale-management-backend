<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderDetailsRequest;
use App\Http\Resources\OrderDetailsResource;
use App\Models\OrderDetails;

class OrderDetailsController extends Controller
{
    public function show($id){
        $orderDetail= OrderDetails::with(['order', 'product'])->findOrFail($id);
        return new OrderDetailsResource($orderDetail);
    }

    public function store(OrderDetailsRequest $request){
        $validated = $request->validated();
    
        $orderDetail = OrderDetails::create($validated);
    
        return response()->json([
            "message" => "Order detail created successfully",
            "data" => new OrderDetailsResource($orderDetail)
        ], 201);
    }

    public function getByOrderId($order_id){
        $orderDetails= OrderDetails::with(['order','product'])->where('order_id',$order_id)->get();
        
        return OrderDetailsResource::collection($orderDetails);
    }
}
