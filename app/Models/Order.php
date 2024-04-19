<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contract_number',
        'contract_date',
        'completion_at',
        'client_id',
        'status',
        'source',
        'contact_person',
        'phone',
        'organizational_form',
        'contract_amount',
        'paid',
        'debt',
        'profit',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'contract_date' => 'datetime',
        'completion_at' => 'datetime',
        'client_id' => 'integer',
        'contract_amount' => 'double',
        'paid' => 'double',
        'debt' => 'double',
        'profit' => 'double',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
