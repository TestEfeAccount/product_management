<?php

namespace App\Repositories;

use App\Enums\LedgerType;
use App\Interfaces\BatchServiceInterface;
use App\Interfaces\ProductServiceInterface;
use App\Interfaces\WarehouseServiceInterface;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\LedgerService;

class OrderRepository
{

    public function __construct(
        protected WarehouseServiceInterface $warehouseService,
        protected BatchServiceInterface     $batchService,
        protected ProductServiceInterface   $productService,
        protected LedgerService             $ledgerService
    )
    {

    }

    public function createItem($product, $quantity, $order)
    {
        /**
         * getting the oldest batch;
         */
        $warehouseProduct = $this->warehouseService->getProductForOrder($product->id, $quantity);
        $orderItem = new OrderItem();
        $orderItem->warehouse_product_id = $warehouseProduct->id;
        $orderItem->product_id = $product['id'];
        $orderItem->price = $product->price;
        $orderItem->quantity = $quantity;
        $orderItem->total_price = bcmul($product->price, $quantity);

        $order->items()->save($orderItem);
        $warehouseProduct->quantity -= $quantity;
        $warehouseProduct->save();
        $this->ledgerService->stockEntry($warehouseProduct->batch_product_id, $warehouseProduct->warehouse_id, $quantity, LedgerType::OUT);
    }

    public function createOrder($clientId)
    {
        return Order::create(['client_id' => $clientId, 'address' => random_int(10000, 99999)]);
    }
}
