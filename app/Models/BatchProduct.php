<?php

namespace App\Models;

use App\Interfaces\RefundableInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property int $product_id
 * @property int $batch_id
 * @property int $quantity
 * @property string $purchase_price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Product|null $baseProduct
 * @property-read Collection<int, WarehouseProduct> $warehouseProducts
 * @property-read int|null $warehouse_products_count
 * @method static Builder<static>|BatchProduct newModelQuery()
 * @method static Builder<static>|BatchProduct newQuery()
 * @method static Builder<static>|BatchProduct query()
 * @method static Builder<static>|BatchProduct whereBatchId($value)
 * @method static Builder<static>|BatchProduct whereCreatedAt($value)
 * @method static Builder<static>|BatchProduct whereId($value)
 * @method static Builder<static>|BatchProduct whereProductId($value)
 * @method static Builder<static>|BatchProduct wherePurchasePrice($value)
 * @method static Builder<static>|BatchProduct whereQuantity($value)
 * @method static Builder<static>|BatchProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BatchProduct extends Model implements RefundableInterface
{
    protected $table = 'batch_products';
    protected $fillable = ['batch_id', 'product_id', 'quantity','purchase_price'];

    public function baseProduct()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function warehouseProducts()
    {
        return $this->hasMany(WarehouseProduct::class, 'batch_product_id', 'id');
    }

}
