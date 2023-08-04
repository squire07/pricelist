<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    use HasFactory;

    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'transaction_type_id', 'id'); 
    }

    public function sales()
    {
        return $this->belongsTo('App\Models\Sales', 'transaction_type_id', 'id');
    }
}
