<?php

namespace App\Services;


use App\Models\StockLedger;

use Illuminate\Support\Facades\DB;

class StockLedgerService
{

    public function getStockByProductAndWarehouse($date)
    {


        return StockLedger::query()
            ->join('batch_products', 'stock_ledger.batch_product_id', '=', 'batch_products.id')
            ->join('products', 'batch_products.product_id', '=', 'products.id')
            ->select(
                'batch_products.product_id',
                'products.name',
                'stock_ledger.warehouse_id',
                DB::raw('
                    SUM(CASE
                        WHEN stock_ledger.type = 1 THEN stock_ledger.quantity
                        WHEN stock_ledger.type = 2 THEN -stock_ledger.quantity
                        ELSE 0
                    END) as quantity'
                )
            )
            ->where('stock_ledger.created_at', '<=', $date)
            ->groupBy('batch_products.product_id', 'stock_ledger.warehouse_id')
            ->with(['warehouse'])
            ->get();
    }
}
