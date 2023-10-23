<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TransactionType extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    

    // getters and setters
    public function getCreatedAtAttribute($value)
    {
        return $value != null ? Carbon::parse($value)->format('m/d/Y h:i:s A') : '';
    }

    public function getUpdatedAtAttribute($value)
    {
        return $value != null ? Carbon::parse($value)->format('m/d/Y h:i:s A') : '';
    }

    // relationships
    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'transaction_type_id', 'id'); 
    }

    public function sales()
    {
        return $this->belongsTo('App\Models\Sales', 'transaction_type_id', 'id');
    }
}
