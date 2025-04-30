<?php

namespace App\Interfaces;



interface ProductServiceInterface
{

    public function getProductsInStock();

    public function decreaseQuantity($product, int $quantity);
}
