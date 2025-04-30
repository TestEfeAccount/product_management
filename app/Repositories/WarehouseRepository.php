<?php

namespace App\Repositories;

use App\Enums\LedgerType;
use App\Models\WarehouseProduct;
use App\Services\LedgerService;

class WarehouseRepository
{

    public function __construct(protected LedgerService $ledgerService)
    {
    }

    public function addProduct($batchProduct, $batchId, $quantity, $warehouseId)
    {
        $warehouseProduct = new WarehouseProduct();
        $warehouseProduct->batch_product_id = $batchProduct->id;
        $warehouseProduct->batch_id = $batchId;
        $warehouseProduct->quantity = $quantity;
        $warehouseProduct->product_id = $batchProduct->product_id;
        $warehouseProduct->warehouse_id = $warehouseId;
        $warehouseProduct->save();
        $this->ledgerService->stockEntry($batchProduct->id, $warehouseId, $quantity, LedgerType::IN);
    }

    public function getProductsForUpdateByBatchAndProductId($batchId, $batchProductId)
    {
        return WarehouseProduct::where('batch_product_id', $batchProductId)
            ->where('batch_id', $batchId)
            ->lockForUpdate()
            ->get();
    }

    public function checkProductStock($productId, $quantity)
    {

        return WarehouseProduct::where('product_id', $productId)
            ->where('quantity', '>=', $quantity)
            ->exists();

    }

    public function getProductForOrder($productId, $quantity)
    {
        return WarehouseProduct::orderBy('created_at', 'ASC')
            ->where('quantity', '>=', $quantity)
            ->where('product_id', $productId)
            ->lockForUpdate()
            ->first();
    }
}
