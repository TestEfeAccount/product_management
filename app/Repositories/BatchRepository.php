<?php

namespace App\Repositories;

use App\Models\Batch;
use App\Models\BatchProduct;

class BatchRepository
{
    public function createBatch(array $data): Batch
    {
        return Batch::create($data);
    }

    public function createBatchProduct(array $data): BatchProduct
    {
        return BatchProduct::create($data);
    }

    public function getBatchProductForUpdate(int $batchId, int $productId): ?BatchProduct
    {
        return BatchProduct::where('batch_id', $batchId)
            ->where('product_id', $productId)
            ->lockForUpdate()
            ->first();
    }
}
