<?php

namespace App\Services;

use App\Enums\LedgerType;
use App\Interfaces\WarehouseServiceInterface;
use App\Models\Warehouse;
use App\Models\WarehouseProduct;
use App\Repositories\WarehouseRepository;
use Illuminate\Database\Eloquent\Collection;

class WarehouseService implements WarehouseServiceInterface
{

    public function __construct(protected WarehouseRepository $warehouseRepository)
    {
    }

    public function getProductsForUpdateByBatchAndProductId($batchId, $batchProductId)
    {
        return $this->warehouseRepository->getProductsForUpdateByBatchAndProductId($batchId, $batchProductId);
    }

    public function allocateToWarehouse($batchProduct, int $batchId, array $product): void
    {
        if (!array_key_exists('warehouse_id', $product)) {
            $this->allocateProduct($batchProduct, $batchId, $product['quantity']);
        } else {
            $this->warehouseRepository->addProduct($batchProduct, $batchId, $product['quantity'], $product['warehouse_id']);
        }
    }

    public function allocateProduct($batchProduct, $batchId, $quantity): void
    {
        $warehouses = $this->getWarehouses();
        $warehouseCount = count($warehouses);
        if ($warehouseCount <= $quantity) {
            $quantityPerWarehouse = floor($quantity / $warehouseCount);

            $remainder = $quantity % $warehouseCount;
            foreach ($warehouses as $index => $warehouse) {
                $quantity = $quantityPerWarehouse;
                if ($index < $remainder) {
                    $quantity++;
                }
                $this->warehouseRepository->addProduct($batchProduct, $batchId, $quantity, $warehouse->id);
            }
        } else {
            $index = 0;
            while ($quantity > 0 && $index < $warehouseCount) {
                $this->warehouseRepository->addProduct($batchProduct, $batchId, 1, $warehouses[$index]->id);
                $quantity--;
                $index++;
            }
        }
    }

    public function getWarehouses(): Collection
    {
        return Warehouse::all();
    }

    public function checkAvailability($productId, $quantity)
    {

        return $this->warehouseRepository->checkProductStock($productId, $quantity);

    }

    public function getProductForOrder($id, $quantity)
    {
        return $this->warehouseRepository->getProductForOrder($id, $quantity);
    }


}
