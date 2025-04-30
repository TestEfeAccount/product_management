<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $products = [
            [
                'name' => 'Example Sneaker 1',
                'category_id' => 5,
                'price' => 100
            ],
            [
                'name' => 'Example Sneaker 2',
                'category_id' => 5,
                'price' => 120
            ],
            [
                'name' => 'Example Boot 1',
                'category_id' => 6,
                'price' => 200
            ],
            [
                'name' => 'Example Boot 2',
                'category_id' => 6,
                'price' => 200,
            ],
            [
                'name' => 'Example Laptop 1',
                'category_id' => 8,
                'price' => 2000
            ],
            [
                'name' => 'Example Laptop 2',
                'category_id' => 8,
                'price' => 2500
            ],

        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
