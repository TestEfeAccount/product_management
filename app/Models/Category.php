<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
class Category extends Model
{
    use NodeTrait;

    protected $table = 'categories';
    protected $fillable = ['name','provider_id','_lft','_rgt','parent_id'];

}
