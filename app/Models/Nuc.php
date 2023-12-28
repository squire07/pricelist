<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nuc extends Model
{
    use HasFactory;

    // relationship
    public function distributor()
    {
        return $this->hasOne('App\Models\Distributor', 'id', 'id');
    }

    // getter and setter

    public function setBcidAttribute($value)
    {
        $this->attributes['bcid'] = substr(str_repeat(0, 12).$value, - 12);
    }
}
