<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Handle extends Model
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
        'color',
        'price',
        'variants',

        "sku",
        "comment",
        "brand",
        "weight",
        "material",
        "material_description",
        "coverage",
        "serial",
        "model",
        "characteristics",
        "base_shape",
        "socket_diameter",
        "square_length",
        "guarantee",
        "dimensions",

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'order_position' => 'integer',
        'price' => 'json',
        'variants' => 'array',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
