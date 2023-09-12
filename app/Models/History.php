<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class History extends Model
{
    use HasFactory;

    public function status()
    {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }

    public function transaction_type()
    {
        return $this->hasOne('App\Models\TransactionType', 'id', 'transaction_type_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return $value != null ? Carbon::parse($value)->format('m/d/Y h:i:s A') : '';
    }
}
