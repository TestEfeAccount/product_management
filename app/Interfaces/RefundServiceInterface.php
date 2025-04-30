<?php

namespace App\Interfaces;

use App\Models\BatchProduct;

interface RefundServiceInterface
{
    /**
     *
     * @param RefundBatchDTO $refundBatchDTO
     * @return array
     * @throws \Throwable
     */


    public function refund(string $type, BatchProduct $batchProduct,  $warehouseProducts, int $quantity);
}
