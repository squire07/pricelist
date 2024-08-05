<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SrpTypes extends Model
{
    use HasFactory;

    public function customers()
    {
        return $this->belongsTo('App\Models\Customers', 'srp_type_id', 'id');
    }
}
