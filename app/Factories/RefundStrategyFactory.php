<?php

namespace App\Factories;

use App\Interfaces\OrderServiceInterface;
use App\Interfaces\RefundStrategyInterface;
use App\Strategies\OrderRefundStrategy;
use App\Strategies\BatchRefundStrategy;
use App\Interfaces\ProductServiceInterface;
use App\Interfaces\LedgerServiceInterface;

class RefundStrategyFactory
{
    protected ProductServiceInterface $productService;
    protected LedgerServiceInterface $ledgerService;
    protected OrderServiceInterface $orderService;

    protected array $strategies = [
        'order' => OrderRefundStrategy::class,
        'batch' => BatchRefundStrategy::class,
    ];

    public function __construct(ProductServiceInterface $productService, LedgerServiceInterface $ledgerService,OrderServiceInterface $orderService)
    {
        $this->productService = $productService;
        $this->ledgerService = $ledgerService;
        $this->orderService = $orderService;
    }
    /**
 * @param string $refundType
     * @return RefundStrategyInterface
     * @throws \InvalidArgumentException
     */
    public function create(string $refundType): RefundStrategyInterface
    {
        if (!array_key_exists($refundType, $this->strategies)) {
            throw new \InvalidArgumentException("Unknown refund type: $refundType");
        }
        $strategyClass = $this->strategies[$refundType];
        return new $strategyClass($this->productService, $this->ledgerService, $this->orderService);
    }
}
