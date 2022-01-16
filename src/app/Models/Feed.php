<?php

namespace App\Models;

use App\Models\User;
use App\Models\FoodCatalog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


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
        'user_id',
        'food_id',
    ];

    /**
     * @var string table name
     */
    protected $table = 'feeds';

    /**
     * get the User who has this feed information.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * get the User who has this feed information.
     */
    public function food(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(FoodCatalog::class);
    }
}
