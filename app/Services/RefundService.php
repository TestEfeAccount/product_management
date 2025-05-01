<?php

namespace App\Services;

use App\Factories\RefundStrategyFactory;
use App\Http\Responses\ApiResponse;
use App\Interfaces\RefundServiceInterface;
use App\Managers\RefundManager;
use App\Models\BatchProduct;
use App\Models\WarehouseProduct;
use App\Trait\BuildMessageTrait;
use App\Trait\ExecuteInTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Exceptions\QuantityException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class RefundService implements RefundServiceInterface
{
    use ExecuteInTransaction, BuildMessageTrait;

    /**
     * @var RefundStrategyFactory
     */
    protected RefundStrategyFactory $strategyFactory;

    /**
     * @param RefundStrategyFactory $strategyFactory
     */
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

    public function processRefund(string $refundType, BatchProduct $batchProduct, $warehouseProducts, int $quantity): JsonResponse
    {
        try {
            $result = $this->refund($refundType, $batchProduct, $warehouseProducts, $quantity);

            return ApiResponse::success($result['message'], $result['data']);
        } catch (\InvalidArgumentException $e) {
            return ApiResponse::error('Invalid refund type.', 400);
        } catch (\Exception|Throwable $e) {
            return ApiResponse::error('An error occurred while processing the refund.', 500);
        }
    }

    /**
     * @param string $type
     * @param BatchProduct $batchProduct
     * @param $warehouseProducts
     * @param int $quantity
     * @return array
     * @throws Throwable
     */
    public function refund(string $type, BatchProduct $batchProduct, $warehouseProducts, int $quantity): array
    {
        return $this->executeInTransaction(function () use ($type, $batchProduct, $warehouseProducts, $quantity) {

            $strategy = $this->strategyFactory->create($type);
            $refundManager = new RefundManager($strategy);
            $refundManager->handle($batchProduct, $warehouseProducts, $quantity);
            return $this->buildSuccessResponse(null, 'Refund successful');

        });

    }
}
