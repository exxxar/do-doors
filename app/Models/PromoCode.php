<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromoCode extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'discount',
        'description',
        'end_at',
        'is_active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'discount' => 'double',
        'is_active' => 'boolean',
        'end_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $with = ["histories"];

    protected $appends = ["activation_count"];

    public function getActivationCountAttribute()
    {
        return $this->histories()->count() ?? 0;
    }

    public function histories(): belongsTo
    {
        return $this->belongsTo(PromoCodeHistory::class);
    }
}
