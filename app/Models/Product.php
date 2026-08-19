<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name','price','description','stock'];

    protected $hidden = [ 'created_at','updated_at'];

    public function images () {return $this->hasMany(ProductImage::class);}
}
