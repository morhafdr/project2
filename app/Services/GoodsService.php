<?php

namespace App\Services;

use App\Models\Cargo_manifest;
use App\Models\Incoming_good;
use App\Models\Order;
use App\Models\Trips;
use App\Models\VariableValue;

class GoodsService
{
    public function createIncomingGood($data)
    {
        return Incoming_good::create($data);
    }
    public function processIncomingGoods($goodsList, $order, $warehouseId)
    {
        $totalPrice = 0;
        $incomingGoods = [];
        foreach ($goodsList as $goodsData) {
            $pricePerKm = VariableValue::where('key', "PricePerKm")->where('weight',$goodsData['weight'])->first()->value;
            $distancePerkm = Trips::where('from_office_id',$order->from_office_id)
                ->where('to_office_id',$order->to_office_id)->pluck('distancePerKm')->first();
            $distancePrice = $pricePerKm * $distancePerkm;
            $goodsData['order_id'] = $order->id;
            $goodsData['warehouse_id'] = $warehouseId;
            $goodsData['status'] = $order->status;
            $goodsData['price'] = $goodsData['quantity'] *$distancePrice;
            $totalPrice += $goodsData['price'];
            $incomingGood = $this->createIncomingGood($goodsData);

            if($order->employee_id !=null) {
                $this->createCargoManifest($incomingGood, $order);
            }
            $incomingGoods[] = $incomingGood;
        }
        return ['totalPrice' => $totalPrice, 'incomingGoods' => $incomingGoods];
    }

    public function createCargoManifest(Incoming_good $incomingGood, Order $order)
    {
        // Find a trip with matching from_office_id and to_office_id
        $trip = Trips::where('from_office_id', $order->from_office_id)
            ->where('to_office_id', $order->to_office_id)
            ->first();
        if ($trip) {
            Cargo_manifest::updateorcreate([
                'trip_id' => $trip->id,
                'incoming_good_id' => $incomingGood->id,
            ]);
        }
    }
    public function updateSingleGood($orderId, $goodsData, $index)
    {
        $order = Order::findOrFail($orderId);
        $good = $order->goods[$index] ?? null; // Find the good based on index or create a new one
        if ($good) {
            // Update only the fields provided
            $good->update(array_filter($goodsData, function($value) {
                return $value !== null;
            }));
        }
    }

}
