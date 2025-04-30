<?php

namespace App\Interfaces;

use App\Models\BatchProduct;
use Illuminate\Support\Collection;

interface RefundStrategyInterface
{
    /**

     * @param BatchProduct $batchProduct
     * @param Collection $warehouseProducts
     * @param int $quantity
     * @return void
     */
    public function refund(BatchProduct $batchProduct, RefundableInterface $warehouseProducts, int $quantity): void;
}
