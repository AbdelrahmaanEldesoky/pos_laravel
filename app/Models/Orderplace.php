<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orderplace extends Model
{
    protected $table = 'orderplaces';
    protected $guarded = [];

    public function place()
    {
        return $this->belongsTo(place::class);

    }//end of user

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_order')->withPivot('quantity');

    }//end of products

}//end of model
