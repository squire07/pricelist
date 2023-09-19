<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SalesInvoiceAssignment extends Model
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


    // Series From
    public function setSeriesFromAttribute($value)
    {
        $this->attributes['series_from'] = substr(str_repeat(0, 6).$value, - 6);
    }

    public function getSeriesFromAttribute($value)
    {
        return substr(str_repeat(0, 6).$value, - 6);
    }

    // Series To
    public function setSeriesToAttribute($value)
    {
        $this->attributes['series_to'] = substr(str_repeat(0, 6).$value, - 6);
    }

    public function getSeriesToAttribute($value)
    {
        return substr(str_repeat(0, 6).$value, - 6);
    }


    // relationships
    public function cashier()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function branch()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'branch_id');
    }

    public function booklet_details()
    {
        return $this->hasMany('App\Models\SalesInvoiceAssignmentDetail', 'sales_invoice_assignment_id', 'id');
    }


}
