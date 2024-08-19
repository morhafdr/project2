<?php

namespace App\Http\Resources\order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'order_id' => $this->order_id,
            'S_user' => $this->S_user,
            'S_national_id' => $this->S_national_id,
            'S_phone_number' => $this->S_phone_number,
            'S_family_registration' => $this->S_family_registration,
            'S_mother_name' => $this->S_mother_name,
            'S_Location' => $this->S_Location,
            'R_user' => $this->R_user,
            'R_phone_number' => $this->R_phone_number,
            'payment_timing' => $this->payment_timing,
        ];
    }
}
