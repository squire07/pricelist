<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public function sales()
    {
        return $this->belongsTo('App\Models\Sales', 'status_id', 'id');
    }

}
