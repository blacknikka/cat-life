<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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
