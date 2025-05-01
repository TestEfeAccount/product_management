<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\BatchRefundRequest;
use App\Http\Requests\OrderRefundRequest;
use App\Http\Responses\ApiResponse;
use App\Interfaces\RefundServiceInterface;
use App\Models\BatchProduct;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RefundController extends Controller
{
    public function __construct(protected RefundServiceInterface $refundService)
    {
    }

    /**
     * Process a batch refund.
     *
     * @param BatchRefundRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function refundBatch(BatchRefundRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $batchProduct = BatchProduct::where([
            'batch_id' => $validated['batch_id'],
            'product_id' => $validated['product_id']
        ])->firstOrFail();
        $warehouseProducts = $batchProduct->warehouseProducts;

        return $this->refundService->processRefund('batch', $batchProduct, $warehouseProducts, $validated['quantity']);
    }

    /**
     * Process an order refund.
     *
     * @param OrderRefundRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function refundOrder(OrderRefundRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $orderItem = OrderItem::with(['warehouseProduct.batchProduct'])
            ->where('order_id', $validated['order_id'])
            ->whereHas('order', fn($query) => $query->where('client_id', $validated['client_id']))
            ->lockForUpdate()
            ->findOrFail($validated['order_item_id']);

        $warehouseProduct = $orderItem->warehouseProduct;
        $batchProduct = $warehouseProduct->batchProduct;

        return $this->refundService->processRefund('order', $batchProduct, $warehouseProduct, $validated['quantity']);
    }


}
