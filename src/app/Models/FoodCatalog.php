<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

/**
 * App\Models\FoodCatalog
 *
 * @property int $id
 * @property string $name
 * @property string|null $maker
 * @property float|null $calorie
 * @property string|null $memo
 * @property mixed|null $picture
 * @property string|null $url
 * @property int $is_master
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $user
 * @method static \Database\Factories\FoodCatalogFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodCatalog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FoodCatalog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FoodCatalog query()
 * @method static \Illuminate\Database\Eloquent\Builder|FoodCatalog whereCalorie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodCatalog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodCatalog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodCatalog whereIsMaster($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodCatalog whereMaker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodCatalog whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodCatalog whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodCatalog wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodCatalog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodCatalog whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodCatalog whereUserId($value)
 * @mixin \Eloquent
 */
class FoodCatalog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'maker',
        'calorie',
        'memo',
        'picture',
        'url',
        'is_master',
        'user_id',
    ];

    /**
     * @var string table name
     */
    protected $table = 'food_catalogs';

    /**
     * get the User who has this food catalog.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
