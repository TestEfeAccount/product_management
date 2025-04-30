<?php

namespace App\Http\Controllers;

use App\DTO\PurchaseBatchDTO;
use App\Http\Requests\PurchaseProductRequest;
use App\Http\Responses\ApiResponse;
use App\Interfaces\BatchServiceInterface;
use Exception;


class BatchController extends Controller
{

    public function __construct(protected BatchServiceInterface $batchService)
    {}

    public function purchase(PurchaseProductRequest $request)
    {
        try {
            $validated =$request->validated();
            extract($validated);
            $result = $this->batchService->purchaseBatch(
                new PurchaseBatchDTO($providerId,$products)
            );
            return ApiResponse::success($result['message'], $result['data'],201);
        }
        catch (Exception $e) {
            return ApiResponse::error( $e->getMessage());
        }

    }
    public function calculateProfitPerBatch()
    {
       return   ApiResponse::success('profit',$this->batchService->calculateProfitPerBatch());
    }
}
