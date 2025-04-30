<?php

namespace App\Interfaces;


use App\Models\BatchProduct;
use Illuminate\Database\Eloquent\Collection;

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
