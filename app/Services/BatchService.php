<?php

namespace App\Services;


use App\DTO\PurchaseBatchDTO;
use App\Interfaces\BatchServiceInterface;
use App\Interfaces\WarehouseServiceInterface;
use App\Models\Batch;
use App\Models\OrderItem;
use App\Models\WarehouseProduct;
use App\Repositories\BatchRepository;
use App\Trait\BuildMessageTrait;
use App\Trait\ExecuteInTransaction;
use Ramsey\Uuid\Uuid;

class BatchService implements BatchServiceInterface
{
    use BuildMessageTrait, ExecuteInTransaction;

    protected BatchRepository $batchRepository;

    public function __construct(
        protected WarehouseServiceInterface $warehouseService,
        BatchRepository                     $batchRepository = null
    )
    {
        $this->batchRepository = $batchRepository ?? new BatchRepository();
    }

    public function getBatchProductForUpdate(int $batchId, int $productId)
    {
        return $this->batchRepository->getBatchProductForUpdate($batchId, $productId);
    }

    public function purchaseBatch(PurchaseBatchDTO $purchaseBatchDTO): array
    {
        return $this->executeInTransaction(function () use ($purchaseBatchDTO) {

            $batch = $this->createBatch($purchaseBatchDTO->providerId);
            $this->processBatchProducts($batch->id, $purchaseBatchDTO->products);

            return $this->buildSuccessResponse(
                $batch->load(['products.baseProduct', 'products.warehouseProducts.warehouse']),
                'Batch successfully purchased!'
            );
        });
    }

    protected function createBatch(int $providerId): Batch
    {
        return $this->batchRepository->createBatch([
            'batch_number' => 'Batch_' . Uuid::uuid4()->toString(),
            'provider_id' => $providerId,
        ]);
    }

    protected function processBatchProducts(int $batchId, array $products): void
    {
        foreach ($products as $product) {
            $batchProduct = $this->batchRepository->createBatchProduct([
                'batch_id' => $batchId,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'purchase_price' => $product['purchase_price'],
            ]);

            $this->warehouseService->allocateToWarehouse($batchProduct, $batchId, $product);
        }
    }

    public function calculateProfitPerBatch()
    {

        $batches = Batch::with('products.baseProduct')
            ->with('products.warehouseProducts.orderItem')
            ->get();

        $profits = [];

        foreach ($batches as $batch) {
            $revenue = 0;
            $cost = 0;



            foreach ($batch->products as $batchProduct) {

                $cost += $batchProduct->purchase_price * $batchProduct->quantity;

                $warehouseProducts = WarehouseProduct::where('batch_product_id', $batchProduct->id)->get();

                foreach ($warehouseProducts as $warehouseProduct) {
                    $orderItems = OrderItem::where('warehouse_product_id', $warehouseProduct->id)->get();
                    foreach ($orderItems as $orderItem) {
                        $revenue += $orderItem->price * $orderItem->quantity;
                    }
                }

            }

            $profit = $revenue - $cost;

            $batchProfits[] = [
                'batch_id' => $batch->id,
                'revenue' => $revenue,
                'cost' => $cost,
                'profit' => $profit,
            ];
        }

        return $batchProfits;
    }

}
