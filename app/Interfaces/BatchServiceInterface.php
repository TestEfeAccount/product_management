<?php

namespace App\Interfaces;

use App\DTO\PurchaseBatchDTO;

interface BatchServiceInterface
{
    public function getBatchProductForUpdate(int $batchId, int $productId);
    public function purchaseBatch(PurchaseBatchDTO $purchaseBatchDTO): array;
}
