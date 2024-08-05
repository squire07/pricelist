<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    public function area_groups()
    {
        return $this->hasOne('App\Models\AreaGroups', 'id', 'area_id');
    }

    public function customer_categories()
    {
        return $this->hasOne('App\Models\CustomerCategories', 'id', 'category_id');
    }

    public function srp_types()
    {
        return $this->hasOne('App\Models\SrpTypes', 'id', 'srp_type_id');
    }
}
