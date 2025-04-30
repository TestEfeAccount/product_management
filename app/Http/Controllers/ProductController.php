<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Interfaces\ProductServiceInterface;


class ProductController extends Controller
{

    public function __construct(protected ProductServiceInterface $productService)
    {

    }

    public function getProducts()
    {
        return ProductResource::collection($this->productService->getProductsInStock());
    }


}
