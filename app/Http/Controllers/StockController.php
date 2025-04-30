<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockByDateRequest;
use App\Http\Resources\StockResource;
use App\Http\Responses\ApiResponse;
use App\Models\StockLedger;
use App\Services\StockLedgerService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StockController extends Controller
{

    public function __construct(protected StockLedgerService $stockLedgerService)
    {

    }
    public function getStockByDate(StockByDateRequest $request)
    {

        try {
            extract($request->validated());
            $date = Carbon::parse($date)->endOfDay();
            $result = $this->stockLedgerService->getStockByProductAndWarehouse($date);
            return StockResource::collection($result);
        }
        catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }

    }
}
