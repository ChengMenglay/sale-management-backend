<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
           'id'=>$this->id,
           'order_id' =>$this->order_id,
           'order'=>$this->whenLoaded('order', function (){
            return new OrderResource($this->order);
           }),
           'product_id'=>$this->product_id,
           'product'=>$this->whenLoaded('product',function(){
            return new ProductResource($this->product);
           }),
           'price'=>$this->price,
           'order_quantity'=>$this->order_quantity,
           'created_at'=>$this->created_at
        ];
    }
}
