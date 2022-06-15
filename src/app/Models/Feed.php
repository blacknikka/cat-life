<?php

namespace App\Models;

use App\Models\Cat;
use App\Models\FoodCatalog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Feed
 *
 * @property int $id
 * @property string $served_at
 * @property float $amount
 * @property string|null $memo
 * @property int|null $user_id
 * @property int|null $food_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read FoodCatalog|null $food
 * @property-read User|null $user
 * @method static \Database\Factories\FeedFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed query()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereFoodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereServedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $cat_id
 * @property-read Cat|null $cat
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereCatId($value)
 */
class Feed extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'served_at',
        'amount',
        'memo',
        'cat_id',
        'food_id',
    ];

    /**
     * @var string table name
     */
    protected $table = 'feeds';

    /**
     * get the Cat who has this feed information.
     */
    public function cat(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cat::class);
    }

    /**
     * get the User who has this feed information.
     */
    public function food(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(FoodCatalog::class);
    }
}
