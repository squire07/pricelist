<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetails extends Model
{
    use HasFactory;


    // relationships
    public function sales() 
    {
        return $this->belongsTo('App\Models\Sales', 'id', 'sales_id');
    }

    public function transaction_type()
    {
        return $this->hasOne('App\Models\TransactionType', 'id', 'transaction_type');
    }



    // getter and setter
    public function getAmountAttribute($value)
    {
        return number_format($value,2,'.',',');
    }

    public function getNucAttribute($value)
    {
        return number_format($value,2,'.',',');
    }

    public function getQuantityAttribute($value)
    {
        return number_format($value,0,'.',',');
    }

    public function getItemPriceAttribute($value)
    {
        return number_format($value,2,'.',',');
    }

    public function setItemPriceAttribute($value)
    {
        $this->attributes['item_price'] = str_replace(',', '', $value);
    }

    public function setItemNucAttribute($value)
    {
        $this->attributes['item_nuc'] = str_replace(',', '', $value);
    }

    public function setQuantityAttribute($value)
    {
        $this->attributes['quantity'] = str_replace(',', '', $value);
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = str_replace(',', '', $value);
    }

    public function setNucAttribute($value)
    {
        $this->attributes['nuc'] = str_replace(',', '', $value);
    }

}
