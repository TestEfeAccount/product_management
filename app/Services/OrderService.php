<?php

namespace App\Services;

use App\DTO\OrderDTO;
use App\Interfaces\OrderServiceInterface;
use App\Interfaces\WarehouseServiceInterface;
use App\Models\Product;
use App\Repositories\OrderRepository;
use App\Trait\BuildMessageTrait;
use App\Trait\ExecuteInTransaction;
use Throwable;

class OrderService implements OrderServiceInterface
{
    use BuildMessageTrait;
    use ExecuteInTransaction;

    /**
     * @param WarehouseServiceInterface $warehouseService
     * @param OrderRepository $orderRepository
     */
    public function __construct(
        protected WarehouseServiceInterface $warehouseService,
        protected OrderRepository           $orderRepository
    )
    {
    }

    /**
     * @param OrderDTO $orderDto
     * @return array|mixed
     * @throws Throwable
     */
    public function createOrder(OrderDto $orderDto)
    {
        if (!$this->canBePurchased($orderDto->products)) {
            return $this->buildCustomMessageResponse('A product is not available for order');
        };
        return $this->buildOrder($orderDto);
    }

    /**
     * @param $products
     * @return bool
     */
    private function canBePurchased($products)
    {
        foreach ($products as $product) {
            if (!$this->warehouseService->checkAvailability($product['id'], $product['qty'])) {
                return false;
            };
        }
        return true;
    }

    /**
     * @param OrderDTO $orderDto
     * @return mixed
     * @throws Throwable
     */
    private function buildOrder(OrderDto $orderDto)
    {
        return $this->executeInTransaction(function () use ($orderDto) {

            $order = $this->orderRepository->createOrder($orderDto->clientId);
            foreach ($orderDto->products as $product) {
                $this->addItemToOrder($product, $order);
            }
            return $this->buildSuccessResponse($order->load('items.product'), 'Order successful');
        });
    }

    /**
     * @param $product
     * @param $order
     * @return void
     */
    private function addItemToOrder($product, $order)
    {
        $baseProduct = Product::find($product['id']);
        $this->orderRepository->addItemToOrder($baseProduct, $product['qty'], $order);
    }
}
