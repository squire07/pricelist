<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    public function brands()
    {
        return $this->hasOne('App\Models\Brands', 'id', 'brand_id');
    }

    public function product_category()
    {
        return $this->hasOne('App\Models\ProductsCategory', 'id', 'category_id');
    }

    public function getorigSRPAttribute($value)
    {
        return number_format($value,2,'.',',');
    }

    public function getspecSRPAttribute($value)
    {
        return number_format($value,2,'.',',');
    }
}
