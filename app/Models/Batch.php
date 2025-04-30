<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property int $provider_id
 * @property string $batch_number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, \App\Models\BatchProduct> $products
 * @property-read int|null $products_count
 * @method static Builder<static>|Batch newModelQuery()
 * @method static Builder<static>|Batch newQuery()
 * @method static Builder<static>|Batch query()
 * @method static Builder<static>|Batch whereBatchNumber($value)
 * @method static Builder<static>|Batch whereCreatedAt($value)
 * @method static Builder<static>|Batch whereId($value)
 * @method static Builder<static>|Batch whereProviderId($value)
 * @method static Builder<static>|Batch whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Batch extends BaseModel
{
   protected $table = 'batches';

   protected $fillable = ['batch_number','provider_id'];


   public function products()
   {
       return $this->hasMany(BatchProduct::class,'batch_id','id');
   }

}
