<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        'id'=> $this->id,
        'name' => $this->name,
        'category' => $this->category ? $this->category->name : 'No category', // Safely access category
        'category_id'=>$this->category_id,
        'price' =>round($this->price, 2),
        'stock' => $this->stock,
        'tax'=>$this->tax,  
        'barcode'=>$this->barcode,
        'image' => $this->image,
        'status' => $this->status,
        'detail' => $this->detail,
        'created_at' => $this->created_at->format('D/M/Y'),
        ];
    }
}
