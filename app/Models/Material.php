<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'order_position',
        'wrapper_variants',
        'door_variants',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'order_position' => 'integer',
        'wrapper_variants' => 'array',
        'door_variants' => 'array',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function sizes(): HasMany
    {
        return $this->hasMany(Size::class);
    }
}
