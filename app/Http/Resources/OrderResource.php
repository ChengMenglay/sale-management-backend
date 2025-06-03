<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => [
                'name' => $this->user?->name,
                'email' => $this->user?->email,
            ],
            'discount' => $this->discount ?? 0,
            'note' => $this->note ?? "",
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
            'order_status' => $this->order_status,
            'amount_paid' => $this->amount_paid,
            'total' => $this->total,
            'created_at'=>$this->created_at
        ];
    }
}
