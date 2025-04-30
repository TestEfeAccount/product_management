<?php

namespace App\Services;

use App\Enums\LedgerType;
use App\Interfaces\LedgerServiceInterface;
use App\Models\StockLedger;

class LedgerService implements LedgerServiceInterface
{
    public function stockEntry($batchProductId, $warehouseId, $quantity, LedgerType $type)
    {
        $stockLedger = new StockLedger();
        $stockLedger->type = $type;
        $stockLedger->batch_product_id = $batchProductId;
        $stockLedger->warehouse_id = $warehouseId;
        $stockLedger->quantity = $quantity;
        $stockLedger->save();
    }
}
