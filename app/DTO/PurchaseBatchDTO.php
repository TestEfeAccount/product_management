<?php

namespace App\DTO;

readonly class PurchaseBatchDTO
{
    public function __construct(
        public int   $providerId,
        public array $products,

    )
    {
    }
}
