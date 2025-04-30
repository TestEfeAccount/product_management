<?php

namespace App\Managers;

use App\Interfaces\RefundableInterface;
use App\Interfaces\RefundStrategyInterface;
use App\Models\BatchProduct;
use Illuminate\Support\Collection;

class RefundManager
{
    protected RefundStrategyInterface $strategy;

    public function __construct(RefundStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * Handle the refund operation using the injected strategy.
     *
     * @param BatchProduct $batchProduct
     * @param Collection $warehouseProducts
     * @param int $quantity
     * @return void
     */
    public function handle(BatchProduct $batchProduct,  $warehouseProducts, int $quantity): void
    {
        $this->strategy->refund($batchProduct, $warehouseProducts, $quantity);
    }
}
