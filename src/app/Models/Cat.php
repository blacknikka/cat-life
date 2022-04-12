<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

/**
 * App\Models\Cat
 *
 * @property int $id
 * @property string $name
 * @property string|null $birth
 * @property string|null $description
 * @property string|null $picture path to the image
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $user
 * @method static \Database\Factories\CatFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cat query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereUserId($value)
 * @mixin \Eloquent
 */
class Cat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'birth',
        'description',
        'picture',
        'user_id',
    ];

    /**
     * @var string table name
     */
    protected $table = 'cats';

    /**
     * get the User who has this cat.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
