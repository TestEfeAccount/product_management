<?php

namespace App\DTO;

readonly class OrderDTO
{
    public function __construct(
        public int   $clientId,
        public array $products,

    )
    {
    }
}
