<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesInvoiceAssignmentDetail extends Model
{
    use HasFactory;

    // relationships
    public function booklet()
    {
        return $this->hasMany('App\Models\SalesInvoiceAssignment', 'id', 'sales_invoice_assignment_id');
    }
}
