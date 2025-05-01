<?php

namespace App\Repositories;

use App\Enums\LedgerType;
use App\Models\WarehouseProduct;
use App\Services\LedgerService;

class WarehouseRepository
{

    /**
     * @param LedgerService $ledgerService
     */
    public function __construct(protected LedgerService $ledgerService)
    {
    }

    /**
     * @param $batchProduct
     * @param $batchId
     * @param $quantity
     * @param $warehouseId
     * @return void
     */
    public function addProduct($batchProduct, $quantity, $warehouseId)
    {
        $warehouseProduct = new WarehouseProduct();
        $warehouseProduct->batch_product_id = $batchProduct->id;
        $warehouseProduct->batch_id = $batchProduct->batch_id;
        $warehouseProduct->quantity = $quantity;
        $warehouseProduct->product_id = $batchProduct->product_id;
        $warehouseProduct->warehouse_id = $warehouseId;
        $warehouseProduct->save();
        $this->ledgerService->stockEntry($batchProduct->id, $warehouseId, $quantity, LedgerType::IN);
    }

    /**
     * @param $productId
     * @param $quantity
     * @return bool
     */
    public function checkProductStock($productId, $quantity)
    {

        return WarehouseProduct::where('product_id', $productId)
            ->where('quantity', '>=', $quantity)
            ->exists();

    }

    /**
     * @param $productId
     * @param $quantity
     * @return WarehouseProduct|null
     */
    public function getProductForOrder($productId, $quantity): ?WarehouseProduct
    {
        return WarehouseProduct::orderBy('created_at', 'ASC')
            ->where('quantity', '>=', $quantity)
            ->where('product_id', $productId)
            ->lockForUpdate()
            ->first();
    }
}
