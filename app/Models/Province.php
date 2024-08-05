<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    
    public function employees()
    {
        return $this->belongsTo('App\Models\Employees', 'province', 'id');
    }
}
