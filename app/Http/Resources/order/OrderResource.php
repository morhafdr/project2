<?php

namespace App\Http\Resources\order;

use App\Http\Resources\GoodsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [

            'order' => [
                'id' => $this->id,
                'user_id' => $this->user_id,
                'status' => $this->status,
                'from_office_id' => $this->from_office_id,
                'to_office_id' => $this->to_office_id,
                'employee_id' => $this->employee_id,
                'customer_id' => $this->employee_id,
                'payment_method' => $this->payment_method,
                'payment_type' => $this->payment_type,
            ],
//            'orderDetails' => new OrderDetailResource($this->whenLoaded('order_details')),
            'incomingGoods' => new GoodsResource($this->whenLoaded('incomingGoods')),
        ];
    }
}
