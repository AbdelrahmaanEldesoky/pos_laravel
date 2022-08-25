<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;
    protected $with = ['translations'];
    public $translatedAttributes = ['name'];
    protected $guarded = [];


    public function products()
    {
        return $this->hasMany(Product::class);

    }//end of products

}//end of model
