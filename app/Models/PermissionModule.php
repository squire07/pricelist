<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionModule extends Model
{
    use HasFactory;

    // getter and setter
    public function getTypeAttribute($value)
    {
        return ucfirst($value);
    }
}
