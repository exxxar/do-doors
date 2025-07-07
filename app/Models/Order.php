<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'work_days',
        'bitrix24_lead_id',
        'config',
        'delivery_terms',
        'info',
        'total_price',
        'total_count',
        'current_payed',
        'payed_percent',
        'client_data',
        'discount',

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'completion_at' => 'datetime',
        'client_id' => 'integer',
        'contract_amount' => 'double',
        'paid' => 'double',
        'debt' => 'double',
        'profit' => 'double',
        'total_price' => 'double',
        'total_count' => 'double',
        'client_data' => 'array',
        'discount' => 'array',
        'config' => 'array',
        'current_payed' => 'double',
        'payed_percent' => 'integer',
        'contract_date' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $with = ["client"];

    protected $appends = ["cost_price"];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function details():hasMany {
        return $this->hasMany(OrderDetail::class,"order_id","id");
    }

    public function getCostPriceAttribute(){
        if ($this->details()->count()==0)
            return 0;

        return 0;
    }
}
