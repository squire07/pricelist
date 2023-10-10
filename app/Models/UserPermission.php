<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    // relationships
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
