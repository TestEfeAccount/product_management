<?php

namespace App\Services;

use App\DTO\OrderDTO;
use App\Interfaces\OrderServiceInterface;
use App\Interfaces\WarehouseServiceInterface;
use App\Models\Product;
use App\Repositories\OrderRepository;
use App\Trait\BuildMessageTrait;
use App\Trait\ExecuteInTransaction;

class OrderService implements OrderServiceInterface
{
    use BuildMessageTrait;
    use ExecuteInTransaction;

    public function __construct(
        protected WarehouseServiceInterface $warehouseService,
        protected OrderRepository           $orderRepository
    )
    {
    }

    public function createOrder(OrderDto $orderDto)
    {
        if (!$this->canBePurchased($orderDto->products)) {
            return $this->buildCustomMessageResponse('A product is not available for order');
        };
        return $this->buildOrder($orderDto);
    }

    private function canBePurchased($products)
    {
        foreach ($products as $product) {
            if (!$this->warehouseService->checkAvailability($product['id'], $product['qty'])) {
                return false;
            };
        }
        return true;
    }

    private function buildOrder(OrderDto $orderDto)
    {
        return $this->executeInTransaction(function () use ($orderDto) {

            $order = $this->orderRepository->createOrder($orderDto->clientId);
            foreach ($orderDto->products as $product) {
                $this->addItem($product, $order);
            }
            return $this->buildSuccessResponse($order->load('items.product'), 'Order successful');
        });
    }

    private function addItem($product, $order)
    {
        $baseProduct = Product::find($product['id']);
        $this->orderRepository->createItem($baseProduct, $product['qty'], $order);
    }
}
