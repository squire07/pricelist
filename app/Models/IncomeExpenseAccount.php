<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeExpenseAccount extends Model
{
    use HasFactory;


    // relationship
    public function transaction_type()
    {
        return $this->belongsTo('App\Models\TransactionType', 'transaction_type_id', 'id');
    }

    public function company()
    {
        return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }
}
