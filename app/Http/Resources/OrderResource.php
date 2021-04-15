<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'total' => $this->total,
            'transaction_id' => $this->transaction_id,
            'products' => ProductResource::collection($this->whenLoaded('products')),
            'created_at_date' => $this->created_at->format('d F Y'),
            'created_at_time' => $this->created_at->format('H:i:s'),
            'created_at' => $this->created_at->format('d F Y H:i:s'),
        ];
    }
}
