<?php

namespace App\Models;

use App\Interfaces\RefundableInterface;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $warehouse_id
 * @property int $batch_product_id
 * @property int $batch_id
 * @property int $product_id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Warehouse|null $warehouse
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WarehouseProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WarehouseProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WarehouseProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WarehouseProduct whereBatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WarehouseProduct whereBatchProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WarehouseProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WarehouseProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WarehouseProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WarehouseProduct whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WarehouseProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WarehouseProduct whereWarehouseId($value)
 * @mixin \Eloquent
 */
class WarehouseProduct extends Model implements RefundableInterface
{
    protected $table = 'warehouse_products';


    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }
    public function batchProduct()
    {
        return $this->belongsTo(BatchProduct::class, 'batch_product_id', 'id');
    }
    public function orderItem()
    {
        return $this->hasOne(OrderItem::class, 'warehouse_product_id', 'id');
    }
}
