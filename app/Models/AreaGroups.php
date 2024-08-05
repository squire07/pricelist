<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaGroups extends Model
{
    use HasFactory;

    public function customers()
    {
        return $this->belongsTo('App\Models\Customers', 'area_id', 'id');
    }
}
