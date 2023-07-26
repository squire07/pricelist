<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    public function sales_details()
    {
        return $this->hasMany('App\Models\SalesDetails', 'sales_id', 'id');
    }
}
