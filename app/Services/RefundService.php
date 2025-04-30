<?php

namespace App\Services;

use App\Factories\RefundStrategyFactory;
use App\Interfaces\RefundServiceInterface;
use App\Managers\RefundManager;
use App\Models\BatchProduct;
use App\Trait\BuildMessageTrait;
use App\Trait\ExecuteInTransaction;
use Illuminate\Support\Collection;
use App\Exceptions\QuantityException;

class RefundService implements RefundServiceInterface
{
    use ExecuteInTransaction, BuildMessageTrait;

    protected RefundStrategyFactory $strategyFactory;

    public function __construct(RefundStrategyFactory $strategyFactory)
    {
        $this->strategyFactory = $strategyFactory;
    }

    /**
     *
     * @param string $refundOrigin
     * @param BatchProduct $batchProduct
     * @param Collection $warehouseProducts
     * @param int $quantity
     * @return array
     * @throws QuantityException
     */
    public function refund(string $type, BatchProduct $batchProduct,  $warehouseProducts, int $quantity): array
    {
        return $this->executeInTransaction(function () use ($type, $batchProduct, $warehouseProducts, $quantity) {

            $strategy = $this->strategyFactory->create($type);

            $refundManager = new RefundManager($strategy);
            $refundManager->handle($batchProduct, $warehouseProducts, $quantity);
            return $this->buildSuccessResponse(null, 'Refund successful');

        });

    }
}
