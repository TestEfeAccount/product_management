<?php

namespace App\Interfaces;

interface WarehouseServiceInterface
{
    public function allocateProduct(int $batchProductId, int $batchId, int $quantity): void;
    public function getWarehouses();
}
