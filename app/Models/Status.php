<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public function deliveries()
    {
        return $this->belongsTo('App\Models\Deliveries', 'status_id', 'id');
    }

}
