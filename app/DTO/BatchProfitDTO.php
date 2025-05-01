<?php

namespace App\DTO;

class BatchProfitDTO {
    public function __construct(
        public int $batchId,
        public float $revenue,
        public float $cost,
        public float $profit
    ) {}
}
