<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);

    }//end of user



    public function setCreatedAtCreated_atAttribute($value)
    {
        $this->attributes['create_order'] = Carbon::now()->createFromFormat('m/d/Y' , $value)->format('d-m-Y');
    }


    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_order')->withPivot('quantity');

    }//end of products

}//end of model
