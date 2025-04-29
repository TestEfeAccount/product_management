<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{

    public function run()
    {

        $categories = [
            [
                'name' => 'Tea Products',
                'provider_id' => 1,
                'parent_id' => null,
                '_lft' => 1,
                '_rgt' => 6,
            ],
            [
                'name' => 'Green Tea',
                'provider_id' => null,
                'parent_id' => 1,
                '_lft' => 2,
                '_rgt' => 3,
            ],
            [
                'name' => 'Black Tea',
                'provider_id' => null,
                'parent_id' => 1,
                '_lft' => 4,
                '_rgt' => 5,
            ],
            [
                'name' => 'Footwear',
                'provider_id' => 2,
                'parent_id' => null,
                '_lft' => 7,
                '_rgt' => 12,
            ],
            [
                'name' => 'Sneakers',
                'provider_id' => null,
                'parent_id' => 4,
                '_lft' => 8,
                '_rgt' => 9,
            ],
            [
                'name' => 'Boots',
                'provider_id' => null,
                'parent_id' => 4,
                '_lft' => 10,
                '_rgt' => 11,
            ],
            [
                'name' => 'Electronics',
                'provider_id' => 3,
                'parent_id' => null,
                '_lft' => 13,
                '_rgt' => 18,
            ],
            [
                'name' => 'Laptops',
                'provider_id' => null,
                'parent_id' => 7,
                '_lft' => 14,
                '_rgt' => 15,
            ],
            [
                'name' => 'Desktops',
                'provider_id' => null,
                'parent_id' => 7,
                '_lft' => 16,
                '_rgt' => 17,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
