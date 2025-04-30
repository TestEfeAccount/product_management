<?php

namespace App\Http\Controllers;

use App\Http\Requests\BatchRefundRequest;
use App\Http\Requests\OrderRefundRequest;
use App\Http\Responses\ApiResponse;
use App\Interfaces\RefundServiceInterface;
use App\Models\BatchProduct;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;


class RefundController extends Controller
{
    /**
     * @param RefundServiceInterface $refundService
     */
    public function __construct(protected RefundServiceInterface $refundService)
    {
    }

    /**
     * @param BatchRefundRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function refundBatch(BatchRefundRequest $request)
    {
        $validated = $request->validated();
        $batchProduct = BatchProduct::where(['batch_id' => $validated['batch_id'], 'product_id' => $validated['product_id']])->first();
        $warehouseProducts = $batchProduct->warehouseProducts;

        try {
            $result = $this->refundService->refund('batch', $batchProduct, $warehouseProducts, $validated['quantity']);
            return ApiResponse::success($result['message'], $result['data']);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(),null, $e->getCode());
        }
    }

    /**
     * @param OrderRefundRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function refundOrder(OrderRefundRequest $request)
    {
        $validated = $request->validated();
        $orderItem = OrderItem::where('order_id' , $validated['order_id'])
            ->whereHas('order',function($query) use($validated){
                return $query->where('client_id',$validated['client_id']);
            })->lockForUpdate()->findOrFail($validated['order_item_id']);


        $warehouseProduct = $orderItem->warehouseProduct;
        $batchProduct = $warehouseProduct->batchProduct;
        try {
            $result = $this->refundService->refund('order', $batchProduct, $warehouseProduct, $validated['quantity']);
            return ApiResponse::success($result['message'], $result['data']);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }
}

