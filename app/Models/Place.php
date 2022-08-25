<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $guarded = [];

    public function OrderPlace()
    {
        return $this->hasMany(Orderplace::class,'place_id');

    }//end of orders


}//end of model
