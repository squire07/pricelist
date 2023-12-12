<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    use HasFactory;
    protected $fillable = [
        'bcid',
        'distributor',
        'group',
    ];

    // setters
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
    }

    public function setGroupAttribute($value)
    {
        $this->attributes['group'] = trim($value);
    }

    public function setSubgroupAttribute($value)
    {
        $this->attributes['subgroup'] = trim($value);
    }
}
