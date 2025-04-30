<?php

namespace App\Services;

use App\Exceptions\QuantityException;
use App\Interfaces\ProductServiceInterface;
use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\Model;


class ProductService implements ProductServiceInterface
{

    public function getProductsInStock()
    {
        return Product::withSum('warehouseProducts as quantity', 'quantity')->with('category')
            ->having('quantity', '>', 0)
            ->where('category_id', '!=', null)
            ->get();
    }

    /**
     * Decrement the quantity of a product model.
     *
     * @param Model $product
     * @param int $quantity
     * @return bool
     * @throws Exception
     */
    public function decreaseQuantity($product, int $quantity): bool
    {

        if ($product->quantity < $quantity) {
            throw new QuantityException("Not enough quantity to decrease: " . $product::class);
        }
        $product->quantity -= $quantity;
        return $product->save();
    }

    public function increaseQuantity($product, int $quantity): bool
    {

        $product->quantity += $quantity;
        return $product->save();
    }

}
