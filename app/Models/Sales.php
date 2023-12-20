<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Sales extends Model
{
    use HasFactory;

    // relationships
    public function sales_details()
    {
        return $this->hasMany('App\Models\SalesDetails', 'sales_id', 'id');
    }

    public function status()
    {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }

    public function transaction_type()
    {
        return $this->hasOne('App\Models\TransactionType', 'id', 'transaction_type_id');
    }

    public function income_expense_account()
    {
        return $this->hasOne('App\Models\IncomeExpenseAccount', 'transaction_type_id', 'transaction_type_id');
    }

    public function payment()
    {
        return $this->hasOne('App\Models\Payment', 'sales_id', 'id');
    }

    public function company()
    {
        return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }

    public function branch()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'branch_id');
    }

    public function payload()
    {
        return $this->hasOne('App\Models\Payload', 'uuid', 'uuid');
    }


    // getter and setter
    public function getTotalAmountAttribute($value)
    {
        return number_format($value,2,'.',',');
    }

    public function getTotalNucAttribute($value)
    {
        return number_format($value,2,'.',',');
    }

    public function getGrandtotalAmountAttribute($value)
    {
        return number_format($value,2,'.',',');
    }

    public function getShippingFeeAttribute($value)
    {
        return number_format($value,2,'.',',');
    }

    public function getVatableSalesAttribute($value)
    {
        return number_format($value,2,'.',',');
    }

    public function getVatAmountAttribute($value)
    {
        return number_format($value,2,'.',',');
    }

    public function getQuantityAttribute($value)
    {
        return number_format($value,0,'.',',');
    }

    public function getSoNoAttribute($value)
    {
        return strtoupper($value);
    }

    public function getSiNoAttribute($value)
    {
        return strtoupper($value);
    }

    public function getCreatedAtAttribute($value)
    {
        return $value != null ? Carbon::parse($value)->format('m/d/Y h:i:s A') : '';
    }



    public function setShippingFeeAttribute($value)
    {
        $this->attributes['shipping_fee'] = str_replace(',', '', $value);
    }

    public function setTotalAmountAttribute($value)
    {
        $this->attributes['total_amount'] = str_replace(',', '', $value);
    }

    public function setTotalNucAttribute($value)
    {
        $this->attributes['total_nuc'] = str_replace(',', '', $value);
    }

    public function setVatableSalesAttribute($value)
    {
        $this->attributes['vatable_sales'] = str_replace(',', '', $value);
    }

    public function setVatAmountAttribute($value)
    {
        $this->attributes['vat_amount'] = str_replace(',', '', $value);
    }

    public function setGrandtotalAmountAttribute($value)
    {
        $this->attributes['grandtotal_amount'] = str_replace(',', '', $value);
    }
}
