<?php

namespace App\Services;

use App\DTO\BatchProfitDTO;
use App\Models\OrderItem;
use App\Models\WarehouseProduct;

class BatchProfitCalculator
{
    public function calculateProfitPerBatch($batch)
    {
        $revenue = 0;
        $cost = 0;

        foreach ($batch->products as $batchProduct) {

            $cost = bcadd($cost, bcmul($batchProduct->purchase_price, $batchProduct->quantity));
            $warehouseProducts = WarehouseProduct::where('batch_product_id', $batchProduct->id)->get();

            foreach ($warehouseProducts as $warehouseProduct) {
                $orderItems = OrderItem::where('warehouse_product_id', $warehouseProduct->id)->get();
                foreach ($orderItems as $orderItem) {
                    $revenue = bcadd($revenue, bcmul($orderItem->price, $orderItem->quantity));
                }
            }
        }
        $profit = bcsub($revenue, $cost);
        return new BatchProfitDTO($batch->id, $revenue, $cost,  $profit);

    }
}
