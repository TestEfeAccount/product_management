<?php

namespace App\Services;

use App\DTO\PurchaseBatchDTO;
use App\Interfaces\BatchServiceInterface;
use App\Interfaces\WarehouseServiceInterface;
use App\Models\Batch;
use App\Models\BatchProduct;
use App\Repositories\BatchRepository;
use App\Trait\BuildMessageTrait;
use App\Trait\ExecuteInTransaction;
use Ramsey\Uuid\Uuid;
use Throwable;

class BatchService implements BatchServiceInterface
{
    use BuildMessageTrait, ExecuteInTransaction;

    /**
     * @param WarehouseServiceInterface $warehouseService
     * @param BatchRepository $batchRepository
     */
    public function __construct(
        protected WarehouseServiceInterface $warehouseService,
        protected BatchRepository           $batchRepository,
        protected BatchProfitCalculator     $batchProfitCalculator
    )
    {
    }

    /**
     * @param int $batchId
     * @param int $productId
     * @return BatchProduct|null
     */
    public function getBatchProductForUpdate(int $batchId, int $productId)
    {
        return $this->batchRepository->getBatchProductForUpdate($batchId, $productId);
    }

    /**
     * @param PurchaseBatchDTO $purchaseBatchDTO
     * @return array
     * @throws Throwable
     */
    public function purchaseBatch(PurchaseBatchDTO $purchaseBatchDTO): array
    {
        return $this->executeInTransaction(function () use ($purchaseBatchDTO) {

            $batch = $this->createBatch($purchaseBatchDTO->providerId);
            $this->processBatchProducts($batch->id, $purchaseBatchDTO->products);

            return $this->buildSuccessResponse(
                $batch->load(['products.baseProduct', 'products.warehouseProducts.warehouse']),
                'Batch successfully purchased!');
        });
    }

    /**
     * @param int $providerId
     * @return Batch
     */
    protected function createBatch(int $providerId): Batch
    {
        return $this->batchRepository->createBatch([
            'batch_number' => 'Batch_' . Uuid::uuid4()->toString(),
            'provider_id' => $providerId,
        ]);
    }

    /**
     * @param int $batchId
     * @param array $products
     * @return void
     */
    protected function processBatchProducts(int $batchId, array $products): void
    {
        foreach ($products as $product) {
            $batchProduct = $this->batchRepository->createBatchProduct([
                'batch_id' => $batchId,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'purchase_price' => $product['purchase_price'],
            ]);

            $this->warehouseService->allocateToWarehouse($batchProduct, $product);
        }
    }

    /**
     * @return array
     */
    public function calculateProfitPerBatch(): array
    {

        $batches = Batch::with('products.baseProduct')
            ->with('products.warehouseProducts.orderItem')
            ->get();

        $batchProfits = [];
        foreach ($batches as $batch) {
            $batchProfits[] = $this->batchProfitCalculator->calculateProfitPerBatch($batch);
        }

        return $batchProfits;
    }

}
