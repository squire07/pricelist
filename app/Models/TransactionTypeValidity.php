<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TransactionTypeValidity extends Model
{
    use HasFactory;

    // getters and setters
    public function getCreatedAtAttribute($value)
    {
        return $value != null ? Carbon::parse($value)->format('m/d/Y h:i:s A') : '';
    }

    public function getUpdatedAtAttribute($value)
    {
        return $value != null ? Carbon::parse($value)->format('m/d/Y h:i:s A') : '';
    }

    // mutator
    public function setValidFromAttribute($value)
    {
        $this->attributes['valid_from'] = Carbon::parse($value);
    }

    public function setValidToAttribute($value)
    {
        $this->attributes['valid_to'] = Carbon::parse($value);
    }

    public function getValidFromAttribute($value)
    {
        return Carbon::parse($value)->format('m/d/Y');
    }

    public function getValidToAttribute($value)
    {
        return Carbon::parse($value)->format('m/d/Y');
    }

    // relationships

}
