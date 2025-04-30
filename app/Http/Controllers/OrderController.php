<?php

namespace App\Http\Controllers;


use App\DTO\OrderDTO;
use App\Http\Requests\OrderRequest;
use App\Http\Responses\ApiResponse;
use App\Services\OrderService;
use App\Services\ProductService;


class OrderController extends Controller
{

    public function __construct( protected OrderService $orderService)
    {

    }

    public function createOrder(OrderRequest $request)
    {
        try {
            extract( $request->validated() );
            $result =  $this->orderService->createOrder(new OrderDTO($clientId,$products));
            return ApiResponse::success($result['message'],$result['data']);
        }
        catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }

    }
}
