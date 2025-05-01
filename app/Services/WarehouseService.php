<?php
namespace App\Services;

use App\Enums\LedgerType;
use App\Interfaces\WarehouseServiceInterface;
use App\Models\BatchProduct;
use App\Models\Warehouse;
use App\Models\WarehouseProduct;
use App\Repositories\WarehouseRepository;
use Illuminate\Database\Eloquent\Collection;

class WarehouseService implements WarehouseServiceInterface
{
    /**
     * @param WarehouseRepository $warehouseRepository
     */
    public function __construct(protected WarehouseRepository $warehouseRepository)
    {
    }

    /**
     * @param $batchProduct
     * @param array $product
     * @return void
     */
    public function allocateToWarehouse($batchProduct, array $product): void
    {
        if (!array_key_exists('warehouse_id', $product)) {
            $this->allocateProduct($batchProduct,  $product['quantity']);
        } else {
            $this->warehouseRepository->addProduct(
                $batchProduct,
                $batchProduct['quantity'],
                $product['quantity'],
                $product['warehouse_id']
            );
        }
    }

    /**
     * @param BatchProduct $batchProduct
     * @param int $quantity
     * @return void
     */
    public function allocateProduct(BatchProduct $batchProduct, int $quantity): void
    {
        $warehouses = $this->getWarehouses();
        $warehouseCount = $warehouses->count();

        if ($warehouseCount > 0 && $quantity > 0) {
            $this->distributeProductAcrossWarehouses($warehouses, $batchProduct, $quantity);
        }
    }

    /**
     * @param Collection $warehouses
     * @param BatchProduct $batchProduct
     * @param int $quantity
     * @return void
     */
    private function distributeProductAcrossWarehouses(Collection $warehouses, BatchProduct $batchProduct,  int $quantity): void
    {
        $warehouseCount = $warehouses->count();
        $quantityPerWarehouse = floor($quantity / $warehouseCount);
        $remainder = $quantity % $warehouseCount;

        foreach ($warehouses as $index => $warehouse) {
            $allocatedQuantity = $quantityPerWarehouse + ($index < $remainder ? 1 : 0);
            $this->warehouseRepository->addProduct($batchProduct, $allocatedQuantity, $warehouse->id);
        }
    }

    /**
     * @return Collection
     */
    public function getWarehouses(): Collection
    {
        return Warehouse::all();
    }

    /**
     * @param int $productId
     * @param int $quantity
     * @return bool
     */
    public function checkAvailability(int $productId, int $quantity): bool
    {
        return $this->warehouseRepository->checkProductStock($productId, $quantity);
    }

    /**
     * @param int $id
     * @param int $quantity
     * @return WarehouseProduct|null
     */
    public function getProductForOrder(int $id, int $quantity) : ?WarehouseProduct
    {
        return $this->warehouseRepository->getProductForOrder($id, $quantity);
    }
}
