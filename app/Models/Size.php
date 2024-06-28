<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Size extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'width',
        'height',
        'material_id',
        'price',
        'type',
        'price_koef',
        'value',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'material_id' => 'integer',
        'price' => 'array',
        'height' => 'integer',
        'width' => 'integer',
        'price_koef' => 'double',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $with = ["material"];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
