<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nuc extends Model
{
    use HasFactory;

    // relationship
    public function sales()
    {
        return $this->hasOne('App\Models\Sales', 'uuid', 'uuid');
    }

    public function distributor()
    {
        return $this->hasOne('App\Models\Distributor', 'bcid', 'bcid');
    }

    public function branch()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'branch_id');
    }

    // getter and setter

    public function setBcidAttribute($value)
    {
        $this->attributes['bcid'] = substr(str_repeat(0, 12).$value, - 12);
    }

    public function getTotalNucAttribute($value)
    {
        return number_format($value,2,'.',',');
    }
}
