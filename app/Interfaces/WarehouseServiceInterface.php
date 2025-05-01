<?php

namespace App\Interfaces;

use App\Models\BatchProduct;

interface WarehouseServiceInterface
{
    public function allocateProduct(BatchProduct $batchProduct, int $quantity): void;
    public function getWarehouses();
}
