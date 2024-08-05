<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    public function barangay()
    {
        return $this->belongsTo('App\Models\Employees', 'barangay', 'id');
    }
}
