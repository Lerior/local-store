<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'description', 'stock'];

    protected $hidden = ['created_at', 'updated_at'];

    public function images()
    {
        return $this->hasMany(ProductImage::class)
            ->orderBy('sort_order');
    }

    public function scopeSearch($query, $search)
    {   
        $words = preg_split('/\s+/', trim($search));
       
        return $query->where( function ($query) use ($words) {
            foreach ($words as $word) {
                $query->where('name', 'like', "%{$word}%");
            }
        });
    }
}
