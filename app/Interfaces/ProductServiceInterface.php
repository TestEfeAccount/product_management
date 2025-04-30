<?php

namespace App\Interfaces;



interface ProductServiceInterface
{

    public function getProductsInStock();

    public function decreaseQuantity(\App\Models\BatchProduct $batchProduct, int $quantity);
}
