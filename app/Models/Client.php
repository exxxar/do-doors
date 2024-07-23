<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'phone',
        'email',
        'fact_address',
        'comment',
        'user_id',
        'title',
        'law_address',
        'inn',
        'kpp',
        'ogrn',
        'okpo',
        'requisites',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'requisites' => 'array',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $with = ["user"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getMainRequisites(){
        $main_requisites = []; 
        foreach ($this->requisites ?? [] as $item) {
            if($item["is_main"]){
                 $main_requisites = $item;
            }
        }
   
      if(empty($main_requisites)){
        $main_requisites["bik"] = "-";
        $main_requisites["checking_account"] = "-";
        $main_requisites["correspondent_account"] = "-";
        $main_requisites["bank"] = "-";
      }

        return $main_requisites;
    }
}
