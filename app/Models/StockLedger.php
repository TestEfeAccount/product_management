<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property int $batch_product_id
 * @property int $warehouse_id
 * @property int $quantity
 * @property int $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BatchProduct|null $batchProduct
 * @property-read \App\Models\Warehouse|null $warehouse
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockLedger newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockLedger newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockLedger query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockLedger whereBatchProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockLedger whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockLedger whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockLedger whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockLedger whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockLedger whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockLedger whereWarehouseId($value)
 * @mixin \Eloquent
 */
class StockLedger extends Model
{
    protected $table = 'stock_ledger';

    public function batchProduct(): BelongsTo
    {
        return $this->belongsTo(BatchProduct::class, 'batch_product_id','id');
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}
