<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
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
        'price',
        'type',
        'code',
        'excludes',
        'assign_with_size',
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
        'excludes' => 'array',
        'assign_with_size' => 'boolean',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
