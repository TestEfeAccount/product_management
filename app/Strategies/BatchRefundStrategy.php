<?php

namespace App\Strategies;

use App\Enums\LedgerType;
use App\Interfaces\RefundableInterface;
use App\Interfaces\RefundStrategyInterface;
use App\Models\BatchProduct;
use App\Interfaces\ProductServiceInterface;
use App\Interfaces\LedgerServiceInterface;

class BatchRefundStrategy implements RefundStrategyInterface
{
    protected ProductServiceInterface $productService;
    protected LedgerServiceInterface $ledgerService;

    public function __construct(ProductServiceInterface $productService, LedgerServiceInterface $ledgerService)
    {
        $this->productService = $productService;
        $this->ledgerService = $ledgerService;
    }

    public function refund(BatchProduct $batchProduct,  $warehouseProducts, int $quantity): void
    {
        $this->productService->decreaseQuantity($batchProduct, $quantity);

        foreach ($warehouseProducts->sortBy('created_at') as $warehouseProduct) {
            if ($warehouseProduct->quantity >= $quantity) {
                $this->productService->decreaseQuantity($warehouseProduct, $quantity);
                $this->ledgerService->stockEntry($warehouseProduct->batch_product_id, $warehouseProduct->warehouse_id, $quantity, LedgerType::OUT);
                break;
            }else {
                $quantity -= $warehouseProduct->quantity;
                $this->productService->decreaseQuantity($warehouseProduct, $warehouseProduct->quantity);
            }
        }
    }
}
