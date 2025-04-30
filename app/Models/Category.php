<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Kalnoy\Nestedset\Collection;
use Kalnoy\Nestedset\NodeTrait;
use Kalnoy\Nestedset\QueryBuilder;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property int|null $provider_id
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Category> $children
 * @property-read int|null $children_count
 * @property-read Category|null $parent
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static QueryBuilder<static>|Category ancestorsAndSelf($id, array $columns = [])
 * @method static QueryBuilder<static>|Category ancestorsOf($id, array $columns = [])
 * @method static QueryBuilder<static>|Category applyNestedSetScope(?string $table = null)
 * @method static QueryBuilder<static>|Category countErrors()
 * @method static QueryBuilder<static>|Category d()
 * @method static QueryBuilder<static>|Category defaultOrder(string $dir = 'asc')
 * @method static QueryBuilder<static>|Category descendantsAndSelf($id, array $columns = [])
 * @method static QueryBuilder<static>|Category descendantsOf($id, array $columns = [], $andSelf = false)
 * @method static QueryBuilder<static>|Category fixSubtree($root)
 * @method static QueryBuilder<static>|Category fixTree($root = null)
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static QueryBuilder<static>|Category getNodeData($id, $required = false)
 * @method static QueryBuilder<static>|Category getPlainNodeData($id, $required = false)
 * @method static QueryBuilder<static>|Category getTotalErrors()
 * @method static QueryBuilder<static>|Category hasChildren()
 * @method static QueryBuilder<static>|Category hasParent()
 * @method static QueryBuilder<static>|Category isBroken()
 * @method static QueryBuilder<static>|Category leaves(array $columns = [])
 * @method static QueryBuilder<static>|Category makeGap(int $cut, int $height)
 * @method static QueryBuilder<static>|Category moveNode($key, $position)
 * @method static QueryBuilder<static>|Category newModelQuery()
 * @method static QueryBuilder<static>|Category newQuery()
 * @method static QueryBuilder<static>|Category orWhereAncestorOf(bool $id, bool $andSelf = false)
 * @method static QueryBuilder<static>|Category orWhereDescendantOf($id)
 * @method static QueryBuilder<static>|Category orWhereNodeBetween($values)
 * @method static QueryBuilder<static>|Category orWhereNotDescendantOf($id)
 * @method static QueryBuilder<static>|Category query()
 * @method static QueryBuilder<static>|Category rebuildSubtree($root, array $data, $delete = false)
 * @method static QueryBuilder<static>|Category rebuildTree(array $data, $delete = false, $root = null)
 * @method static QueryBuilder<static>|Category reversed()
 * @method static QueryBuilder<static>|Category root(array $columns = [])
 * @method static QueryBuilder<static>|Category whereAncestorOf($id, $andSelf = false, $boolean = 'and')
 * @method static QueryBuilder<static>|Category whereAncestorOrSelf($id)
 * @method static QueryBuilder<static>|Category whereCreatedAt($value)
 * @method static QueryBuilder<static>|Category whereDescendantOf($id, $boolean = 'and', $not = false, $andSelf = false)
 * @method static QueryBuilder<static>|Category whereDescendantOrSelf(string $id, string $boolean = 'and', string $not = false)
 * @method static QueryBuilder<static>|Category whereId($value)
 * @method static QueryBuilder<static>|Category whereIsAfter($id, $boolean = 'and')
 * @method static QueryBuilder<static>|Category whereIsBefore($id, $boolean = 'and')
 * @method static QueryBuilder<static>|Category whereIsLeaf()
 * @method static QueryBuilder<static>|Category whereIsRoot()
 * @method static QueryBuilder<static>|Category whereLft($value)
 * @method static QueryBuilder<static>|Category whereName($value)
 * @method static QueryBuilder<static>|Category whereNodeBetween($values, $boolean = 'and', $not = false, $query = null)
 * @method static QueryBuilder<static>|Category whereNotDescendantOf($id)
 * @method static QueryBuilder<static>|Category whereParentId($value)
 * @method static QueryBuilder<static>|Category whereProviderId($value)
 * @method static QueryBuilder<static>|Category whereRgt($value)
 * @method static QueryBuilder<static>|Category whereUpdatedAt($value)
 * @method static QueryBuilder<static>|Category withDepth(string $as = 'depth')
 * @method static QueryBuilder<static>|Category withoutRoot()
 * @mixin \Eloquent
 */
class Category extends Model
{
    use NodeTrait;

    protected $table = 'categories';
    protected $fillable = ['name','provider_id','_lft','_rgt','parent_id'];

}
