<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GoodsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [

            'quantity' => $this->quantity,
            'weight' => $this->weight,
            'volume' => $this->voulme,
            'status' => $this->status,
            'price' => $this->price,
        ];
    }
}
