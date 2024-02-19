<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\TransactionType;

class TransactionTypeController extends Controller
{
    public function is_upc_ubc_transaction($transaction_id)
    {
        return Helper::is_upc_ubc_transaction($transaction_id);
    }
}
