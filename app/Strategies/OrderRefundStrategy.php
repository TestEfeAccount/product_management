<?php

namespace App\Strategies;

use App\Enums\LedgerType;
use App\Interfaces\OrderServiceInterface;
use App\Interfaces\RefundableInterface;
use App\Interfaces\RefundStrategyInterface;
use App\Models\BatchProduct;
use App\Interfaces\ProductServiceInterface;
use App\Interfaces\LedgerServiceInterface;

class OrderRefundStrategy implements RefundStrategyInterface
{
    protected ProductServiceInterface $productService;
    protected LedgerServiceInterface $ledgerService;
    protected OrderServiceInterface $orderService;

    public function __construct(ProductServiceInterface $productService, LedgerServiceInterface $ledgerService,OrderServiceInterface  $orderService)
    {
        $this->productService = $productService;
        $this->ledgerService = $ledgerService;
        $this->orderService = $orderService;
    }
    public function refund(BatchProduct $batchProduct,  $warehouseProduct, int $quantity): void
    {

            if ($warehouseProduct->orderItem->quantity >= $quantity) {
                $this->productService->increaseQuantity($warehouseProduct, $quantity);
                $this->productService->decreaseQuantity($warehouseProduct->orderItem, $quantity);
                $this->ledgerService->stockEntry($warehouseProduct->batch_product_id, $warehouseProduct->warehouse_id, $quantity, LedgerType::IN);
            } else{
                throw new \Exception("Quantity out of stock");
            }



    }
}
