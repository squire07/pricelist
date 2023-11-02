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
        $this->attributes['valid_from'] = !is_null($value) ? Carbon::parse($value) : null;
    }

    public function setValidToAttribute($value)
    {
        $this->attributes['valid_to'] = !is_null($value) ? Carbon::parse($value) : null;
    }

    public function getValidFromAttribute($value)
    {
        return !is_null($value) ? Carbon::parse($value)->format('m/d/Y') : null;
    }

    public function getValidToAttribute($value)
    {
        return !is_null($value) ? Carbon::parse($value)->format('m/d/Y') : null;
    }

    // relationships

}
