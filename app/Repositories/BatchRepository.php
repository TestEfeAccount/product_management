<?php

namespace App\Repositories;

use App\Models\Batch;
use App\Models\BatchProduct;

class BatchRepository
{
    /**
     * @param array $data
     * @return Batch
     */
    public function createBatch(array $data): Batch
    {
        return Batch::create($data);
    }

    /**
     * @param array $data
     * @return BatchProduct
     */
    public function createBatchProduct(array $data): BatchProduct
    {
        return BatchProduct::create($data);
    }

    /**
     * @param int $batchId
     * @param int $productId
     * @return BatchProduct|null
     */
    public function getBatchProductForUpdate(int $batchId, int $productId): ?BatchProduct
    {
        return BatchProduct::where('batch_id', $batchId)
            ->where('product_id', $productId)
            ->lockForUpdate()
            ->first();
    }
}
