<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'door_type',
        'count',
        'price',
        'comment',
        'purpose',
        'door',
        'bitrix24_product_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'order_id' => 'integer',
        'price' => 'double',
        'door' => 'array',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
