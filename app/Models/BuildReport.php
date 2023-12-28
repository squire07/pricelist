<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildReport extends Model
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
}
