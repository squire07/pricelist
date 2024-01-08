<?php

namespace App\Helpers;

use Carbon\Carbon;
use Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Distributor;
use App\Models\History;
use App\Models\IncomeExpenseAccount;
use App\Models\PaymentMethod;
use App\Models\PermissionModule;
use App\Models\Sales;
use App\Models\SalesInvoiceAssignmentDetail;
use App\Models\TransactionType;
use App\Models\User;
use App\Models\UserPermission;
use Auth;
use Session;
use GuzzleHttp\Client;
class Helper {

    // create uuid - non repeating
    public static function uuid($model) 
    {
        $uniqueCode = false;
        $newUuid = '';
        while($uniqueCode == false){
            $newUuid = Str::uuid();
            $uniqueCode = $model::whereUuid($newUuid)->exists() ? false : true;
        }
        return $newUuid;
    }

    // format: SO-20230804-001
    public static function generate_so_no($branch_id)
    {
        // get branch code by branch id
        $branch_code = Branch::whereId($branch_id)->whereDeleted(false)->first()->code;

        // get company code
        $branch = Branch::with('company')->whereId($branch_id)->whereDeleted(false)->first();   
        $company_code = $branch->company->code;   

        // search for so_no with same branch code, company code, current date and get the last record 
        $sales = Sales::where('so_no', 'like', 'SO-' . $branch->cost_center . '-' . Str::upper($company_code) . '-' . Carbon::now()->format('Ymd') . '-%')->latest()->first();

        // get the last 4 character of so number
        $last = isset($sales->so_no) ? substr($sales->so_no, strlen($sales->so_no)-4) : 0;
        // remove leading zeros, then increment by 1
        $last_number = $last == 0 ? 1 : ltrim($last, 0) + 1;

        $check = isset($sales->so_no) && strpos($sales->so_no, Carbon::now()->format('Ymd')); // get current date in yyyymmdd format and compare with the last so_no

        if($check) { // true? increment by 1
            return 'SO-' . $branch->cost_center . '-' . Str::upper($company_code) . '-' . Carbon::now()->format('Ymd') . '-' . substr(str_repeat(0, 4) . $last_number, - 4);
        } else { // false? start at 1 again with new date
            return 'SO-' . $branch->cost_center . '-' . Str::upper($company_code) . '-' . Carbon::now()->format('Ymd') . '-' . substr(str_repeat(0, 4) . '1', - 4);
        }
    }

    public static function badge($status_id)
    {
        switch($status_id) {
            case 1: 
                return 'bg-info';
            case 2: 
                return 'bg-warning';
            case 3: 
                return 'bg-danger';
            case 4: 
                return 'bg-success';
            case 5: 
                return 'bg-primary';
            case 6: 
                return 'bg-success';
            case 7: 
                return 'bg-danger';
            case 8: 
                return 'bg-success';
            case 9: 
                return 'bg-danger';
            default: 
                return 'bg-primary';
        }
    }

    public static function transaction_history($record_id, $record_uuid, $transaction_type_id, $status_id, $so_no, $module, $event_name, $remarks) {
        $history = new History();
        $history->record_id = $record_id;
        $history->uuid = $record_uuid;
        $history->transaction_type_id = $transaction_type_id;
        $history->status_id = $status_id;
        $history->so_no = $so_no;
        $history->module = $module;
        $history->event_name = $event_name;
        $history->remarks = $remarks;
        $history->created_by = Auth::user()->name;
        $history->updated_by = Auth::user()->name;
        $history->created_at = Carbon::now();
        $history->updated_at = Carbon::now();
        $history->save();

        return true;
    }

    public static function erp_transaction_history($record_id, $record_uuid, $transaction_type_id, $status_id, $so_no, $module, $event_name, $remarks, $erpnext_user) {
        $history = new History();
        $history->record_id = $record_id;
        $history->uuid = $record_uuid;
        $history->transaction_type_id = $transaction_type_id;
        $history->status_id = $status_id;
        $history->so_no = $so_no;
        $history->module = $module;
        $history->event_name = $event_name;
        $history->remarks = $remarks;
        $history->created_by = $erpnext_user;
        $history->updated_by = $erpnext_user;
        $history->created_at = Carbon::now();
        $history->updated_at = Carbon::now();
        $history->save();

        return true;
    }


    // should I store this in cache/session or in login method to prevent querying multiple times on every page loads?
    public static function get_user_role_name() {
        $user = User::with('role')->whereId(Auth::user()->id)->firstOrFail();

        // store in session to prevent repeated query on page refresh and/or page transition
        Session::put('role_name', $user->role->name);

        return $user->role->name;
    }

    public static function get_user_branch_name() {
        // there are users who have multiple branches
        $user = User::with('branch')->whereId(Auth::user()->id)->firstOrFail();

        $branch_name = '';

        if(!empty($user->branch_id)) {
            $explode = explode(',', $user->branch_id);

            if(count($explode) > 1) {
                for($i = 0; $i < count($explode); $i++) {
                    // add separator in between branch names, if loop reaches the last, do not add a separator
                    $separator = $i != count($explode) - 1 ? ' / ' : '';

                    // get the branch name only, not as collection
                    $branches = Branch::whereId($explode[$i])->value('name'); 

                    // append if multiple
                    $branch_name .= $branches . $separator;
                }
            } else {
                $branch_name = $user->branch->name;
            }
        }

        // store in session to prevent repeated query on page refresh and/or page transition
        Session::put('branch_name', $branch_name);

        return $branch_name; // this can be single or multiple with '/' as separator
    }

    public static function get_company_id_by_branch_id($branch_id) {
        return Branch::whereId($branch_id)->whereDeleted(false)->first()->company_id;
    }

    public static function get_company_name_by_branch_id($branch_id) {
        $branch = Branch::with('company')->whereId($branch_id)->whereDeleted(false)->first();
        return $branch->company->name;
    }

    public static function get_branch_name_by_id($id) {
        $ids = explode(',', $id);
        $branch_names = [];
        foreach ($ids as $branch_id) {
            $branch = Branch::whereId($branch_id)->whereDeleted(false)->first();
            if ($branch) {
                $branch_names[] = $branch->name;
            }
        }
        return implode(',', $branch_names);  //do not add space between ','
    }

    public static function get_branch_names_by_id_for_si_assignment($ids) {
        $ids = explode(',', $ids);
        $branch_names = [];
        foreach ($ids as $branch_id) {
            $branch = Branch::whereId($branch_id)
                        ->with('company')
                        ->whereHas('company', function ($query) {
                            $query->where('status_id', 8);
                        })
                        ->where('status_id', 8)
                        ->whereDeleted(false)->first(); // get the active only
            if ($branch) {
                $branch_names[] = $branch->name;
            }
        }
        return implode(',', $branch_names);  //do not add space between ','
    }

    public static function get_branch_ids_for_si_assignment($ids) {
        $ids = explode(',', $ids);
        $branch_ids = [];
        foreach ($ids as $branch_id) {
            $branch = Branch::whereId($branch_id)
                        ->with('company')
                        ->whereHas('company', function ($query) {
                            $query->where('status_id', 8);
                        })
                        ->where('status_id', 8)
                        ->whereDeleted(false)->first(); // get the active only
            if ($branch) {
                $branch_ids[] = $branch->id;
            }
        }
        return implode(',', $branch_ids);  //do not add space between ','
    }

    public static function intersect_ids_in_si_assignment($first_id_set, $second_id_set) {
        // this will return only the matching ids ex. 1,7 and 7   result: 7
        $first_set_explode = collect(explode(',', $first_id_set));
        $second_set_explode = collect(explode(',', $second_id_set));
        $ids = $first_set_explode->intersect($second_set_explode);
        return $ids->implode(',');
    }

    public static function get_company_names_by_id($ids) {
        $ids = explode(',', $ids);
        $company_names = [];
        foreach ($ids as $company_id) {
            $company = Company::whereId($company_id)->whereDeleted(false)->first();
            if ($company) {
                $company_names[] = $company->name;
            }
        }
        return implode(',', $company_names); //do not add space between ','
    }

    public static function get_si_assignment_no($id) {
        $si_assignment_detail = SalesInvoiceAssignmentDetail::whereId($id)->first();
        return $si_assignment_detail->prefix_value . $si_assignment_detail->series_number;
    }

    public static function get_distributor_name_by_bcid($bcid) {
        $distributor = Distributor::whereBcid($bcid)->first();
        return trim($distributor->name);
    }

    public static function get_sales_status($si_assignment_id) {
        $status = Sales::with('status')->whereSiAssignmentId($si_assignment_id)->first();
        return $status->status->name ?? null;
    }

    public static function get_redemptions_name_from_history($so_id) {
        // get the redemptions name who finalized the sales order 
        $status = History::whereRecordId($so_id)->whereStatusId(2)->first();
        return $status->created_by;
    }

    public static function get_cashiers_name_from_history($si_id) {
        // get the cashier name who finalized the sales order 
        $status = History::whereRecordId($si_id)->whereStatusId(5)->first();
        return $status->created_by;
    }



    /* 
    *  ERPNext
    */
    public static function get_erpnext_data($param) {
        $client = new Client();

        try {
            $response = $client->get(env('ERPNEXT_URL') . $param, [
                'headers' => [
                    'Authorization' => 'Token ' . env('ERPNEXT_API_KEY') . ':' . env('ERPNEXT_API_SECRET'),
                    'Accept' => 'application/json', 
                ],
            ]);
            return $response;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public static function post_erpnext_data($param, $post_data) {
        $client = new Client();
    
        try {
            $response = $client->post(env('ERPNEXT_URL') . $param, [
                'headers' => [
                    'Authorization' => 'Token ' . env('ERPNEXT_API_KEY') . ':' . env('ERPNEXT_API_SECRET'),
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ],
                'json' => json_decode($post_data, true)
            ]);

            return $response;

        } catch (\ClientException $e) {
            return $e;
        }
    }

    public static function put_erpnext_data($param, $post_data) {
        $client = new Client();
    
        try {
            $response = $client->put(env('ERPNEXT_URL') . $param, [
                'headers' => [
                    'Authorization' => 'Token ' . env('ERPNEXT_API_KEY') . ':' . env('ERPNEXT_API_SECRET'),
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ],
                'json' => json_decode($post_data, true)
            ]);

            return $response;

        } catch (\ClientException $e) {
            return $e;
        }
    }

    public static function create_distributor_payload($bcid) {
        $distributor = Distributor::whereBcid($bcid)->first();

        if (!$distributor) {
            // Handle the case where the distributor doesn't exist, e.g., by returning an error or throwing an exception.
            return [
                'error' => 'Distributor not found for BCID: ' . $bcid,
            ];
        }

        $payload = [
            'customer_name' => trim($distributor->name),
            'customer_type' => 'Company',
            'customer_group' => 'All Customer Groups',
            'territory' => 'All Territories'
        ];

        return json_encode($payload);
    }

    public static function create_so_payload($id) {
        $sales = Sales::with('sales_details', 'company', 'branch')->whereId($id)->first();

        if($sales->company_id == 3) {
            $taxes_and_charges = 'VAT Sales - LOCAL';
            $account_head = '2010120 - Due to BIR -  Value Added Tax - UNO';
        } else if ($sales->company_id == 2) {
            $taxes_and_charges = 'VAT Sales - PREMIER';
            $account_head = '2010120 - Due to BIR -  Value Added Tax - PREMIER';
        }

        // warning: do not update/change the structure. This is erpnext's standard.
        $payload = [
            'doctype' => 'Sales Order',
            'naming_series' => 'SAL-ORD-.YYYY.-',
            'glv2_so_number' => $sales->so_no,
            'company' => $sales->company->name,
            'customer' => Helper::get_distributor_name_by_bcid($sales->bcid) ?? 'DISTRIBUTOR',
            'distributor_name' => Helper::get_distributor_name_by_bcid($sales->bcid),
            'group_name' => $sales->group_name ?? null,
            'transaction_date' => date("Y-m-d", strtotime($sales->created_at)),
            'order_type' => 'Sales',
            'redemption_name' => Helper::get_redemptions_name_from_history($sales->id),
            'cost_center' => $sales->branch->cost_center_name,
            'currency' => $sales->transaction_type->currency ?? 'PHP',
            'selling_price_list' => $sales->transaction_type->name,
            'set_warehouse' => $sales->branch->warehouse,
            'delivery_date' => date("Y-m-d", strtotime($sales->created_at)),
            'taxes_and_charges' => $taxes_and_charges,
            'docstatus' => 1,
            'taxes' => [
                [
                    'charge_type' => 'On Net Total',
                    'account_head' => $account_head,
                    'description' => 'Due to BIR -  Value Added Tax',
                    'included_in_print_rate' => 1,
                    'cost_center' => $sales->branch->cost_center_name,
                    'rate' => '12',
                    'docstatus' => 1
                ]
            ]
        ];

        // Use a foreach loop to add items to the 'items' array
        foreach ($sales->sales_details as $detail) {
            $payload['items'][] = [
                'item_code' => $detail->item_code,
                'item_name' => $detail->item_name,
                'qty' => $detail->quantity,
                'docstatus' => 1
            ];
        }

        return json_encode($payload);
    }

    public static function create_comment_payload($comment) {
        $payload = [
            'comment_type' => 'Comment',
            'reference_doctype' => 'Sales Invoice',
            'comment_by' => Auth::user()->name,
            'content' => Auth::user()->name . ': ' . $comment,
            'doctype' => 'Comment'
        ];
        return json_encode($payload);
    }

    public static function create_si_payload($id) {
        $sales = Sales::with('sales_details', 'payment', 'company', 'branch')->whereId($id)->first();


        $debit_to_account = '';
        // get the payment method from the payment details
        if(isset($sales->payment) && !empty($sales->payment->details)) {
            $payments = json_decode($sales->payment->details, true);

            // for now, there is only one payment method accepted
            foreach($payments as $payment) {
                // get the payment description from the payment methods table using the payment id
                $payment_details = PaymentMethod::whereId($payment['id'])->first();
                $debit_to_account = $payment_details->description;
                $is_debit_to = $payment_details->is_debit_to == 1 ? 1 : 0;
            }
        }

        if($sales->company_id == 3) {
            $naming_series = 'LO-SI-V-.YYYY.-';
            $taxes_and_charges = 'VAT Sales - LOCAL';
            $account_head = '2010120 - Due to BIR -  Value Added Tax - UNO';

            if($is_debit_to == 1) {
                $debit_to = $debit_to_account;
            } else {
                $debit_to = '1101001 - Accounts Receivable - Trade - UNO';
            }
            
        } else if ($sales->company_id == 2) {
            $naming_series = 'PR-SI-V-.YYYY.-';
            $taxes_and_charges = 'VAT Sales - PREMIER';
            $account_head = '2010120 - Due to BIR -  Value Added Tax - PREMIER';

            if($is_debit_to == 1) {
                $debit_to = $debit_to_account;
            } else {
                $debit_to = '1101001 - Accounts Receivable - Trade - PREMIER';
            }
                    
        }

        // get the income and expense accounts
        $accounts = IncomeExpenseAccount::whereTransactionTypeId($sales->transaction_type_id)
                        ->whereCompanyId($sales->company_id)
                        ->whereDeleted(0)
                        ->first();


        // warning: do not update/change the structure. This is erpnext's standard.
        $payload = [
            'doctype' => 'Sales Invoice',
            'naming_series' => $naming_series,
            'glv2_si_number' => $sales->si_no,
            'invoice_number' => Helper::get_si_assignment_no($sales->si_assignment_id),
            'company' => $sales->company->name,
            'customer' => Helper::get_distributor_name_by_bcid($sales->bcid) ?? 'DISTRIBUTOR',
            'distributor_name' => Helper::get_distributor_name_by_bcid($sales->bcid),
            'group_name' => $sales->group_name,
            'transaction_date' => date("Y-m-d", strtotime($sales->created_at)),
            'order_type' => 'Sales',
            'cashier_name' => Helper::get_cashiers_name_from_history($sales->id),
            'cost_center' => $sales->branch->cost_center_name,
            'currency' => $sales->transaction_type->currency ?? 'PHP',
            'selling_price_list' => $sales->transaction_type->name,
            'set_warehouse' => $sales->branch->warehouse,
            'delivery_date' => date("Y-m-d", strtotime($sales->created_at)),
            'taxes_and_charges' => $taxes_and_charges,
            'debit_to' => $debit_to,
            'update_stock' => 1,
            'docstatus' => 1,
            'taxes' => [
                [
                    'charge_type' => 'On Net Total',
                    'account_head' => $account_head,
                    'description' => 'Due to BIR -  Value Added Tax',
                    'included_in_print_rate' => 1,
                    'cost_center' => $sales->branch->cost_center_name,
                    'rate' => '12',
                    'docstatus' => 1
                ]
            ]
        ];

        // Use a foreach loop to add items to the 'items' array
        foreach ($sales->sales_details as $detail) {
            $payload['items'][] = [
                'item_code' => $detail->item_code,
                'item_name' => $detail->item_name,
                'qty' => $detail->quantity,
                'income_account' => $accounts->income_account ?? null,
                'expense_account' => $accounts->expense_account ?? null, 
                'cost_center' => $sales->branch->cost_center_name,
                'docstatus' => 1
            ];
        }

        return json_encode($payload);
    }


    public static function create_payment_payload($id) {
        $sales = Sales::with('sales_details', 'payment', 'company', 'branch')->whereId($id)->first();

        $payment_entries = [];
        $reference_no = null;

        // get the payment method from the payment details
        if(isset($sales->payment) && !empty($sales->payment->details)) {
            $payments = json_decode($sales->payment->details, true);

            foreach($payments as $payment) {
                // get the payment description from the payment methods table using the payment id
                $payment_details = PaymentMethod::whereId($payment['id'])->first();

                $naming_series = 'ACC-PAY-.YYYY.-';

                $reference_no = $payment['ref_no'];

                // this code can be refactored into ternary type but let us keep this way for easy understanding
                if($sales->company_id == 3) {
                    if($payment_details->is_debit_to == 0) {
                        $paid_from = '1101001 - Accounts Receivable - Trade - UNO';
                        $paid_to = $payment_details->description;
                    } else {
                        $paid_from = $payment_details->description;
                        $paid_to = '1010002 - Cash - Undeposited Collections - UNO';
                    }
                } else if ($sales->company_id == 2) {
                    if($payment_details->is_debit_to == 0) {
                        $paid_from = '1101001 - Accounts Receivable - Trade - PREMIER';
                        $paid_to = $payment_details->description;
                    } else {
                        $paid_from = $payment_details->description;
                        $paid_to = '1010002 - Cash - Undeposited Collections - PREMIER';
                    }
                }

                // this is the amount per payment method
                    if(count($payments) > 1) {
                        if($payment['name'] == 'CASH' || $payment['name'] == 'cash') {
                            $total_amount = str_replace(',', '', $payment['amount'] - $sales->payment->change); 
                        } else {
                            $total_amount = str_replace(',', '', $payment['amount']); 
                        }
                    } else {
                        // get the grandtotal_amount only if there is only one payment method
                        $total_amount = str_replace(',', '', $sales->grandtotal_amount); 
                    }

                // warning: do not update/change the structure. This is erpnext's standard.
                $payload = [
                    'doctype' => 'Payment Entry',
                    'naming_series' => $naming_series,
                    'party_type' => 'Customer',
                    'party' => Helper::get_distributor_name_by_bcid($sales->bcid) ?? 'DISTRIBUTOR',
                    'company' => $sales->company->name,
                    'due_date' => date("Y-m-d", strtotime($sales->created_at)),
                    'paid_amount' => floatval($total_amount), 
                    'received_amount' => floatval($total_amount),
                    'target_exchange_rate' => 1.0,
                    'paid_from' => $paid_from,
                    'paid_to' => $paid_to,
                    'currency' => $sales->transaction_type->currency ?? 'PHP',
                    'cost_center' => $sales->branch->cost_center_name,
                    'status' => 'Submitted',
                    'docstatus' => 1,
                    'reference_no' => $reference_no,
                    'reference_date' => date("Y-m-d", strtotime($sales->payment->created_at)),
                    'references' => [
                        [
                            'parentfield' => 'references',
                            'parenttype' => 'Payment Entry',
                            'docstatus' => 1,
                            'reference_doctype' => 'Sales Invoice',
                            'due_date' => date("Y-m-d", strtotime($sales->created_at)),
                            'total_amount' => floatval($total_amount),
                            'outstanding_amount' => floatval($total_amount),
                            'allocated_amount' => floatval($total_amount),
                            'exchange_rate' => 1.0,
                            'exchange_gain_loss' => 0.0,
                            'doctype' => 'Payment Entry Reference'
                        ]
                    ]
                ];

                $payment_entries[] = $payload;
            }
        }

        return json_encode($payment_entries);
    }

    // button permission
    public static function BP($module_id, $method_id) {
        $permissions = UserPermission::whereUserId(Auth::user()->id)->first();
        $module = json_decode($permissions->user_permission,true);
        if (isset($module[$module_id][$method_id]) && $module[$module_id][$method_id] === 1) {
            return null;
        } else {
            return 'disabled';
        } 
    }

    // menu permission
    public static function MP($module_id, $method_id) {
        $permissions = UserPermission::whereUserId(Auth::user()->id)->first();
        $module = json_decode($permissions->user_permission,true);
        if (isset($module[$module_id][$method_id]) && $module[$module_id][$method_id] === 1) {
            return true;
        } else {
            return false;
        } 
    }

    public static function sales_invoice_prefix($iteration) 
    {
        // dev 
        $prefix = array(
            21 => 'A',
            41 => 'B',
            61 => 'C',
            81 => 'D',
            101 => 'E',
            121 => 'F',
            141 => 'G',
            161 => 'H',
            181 => 'I',
            201 => 'J',
            221 => 'K',
            241 => 'L',
            261 => 'M',
            281 => 'N',
            301 => 'O',
            321 => 'P',
            341 => 'Q',
            361 => 'R',
            381 => 'S',
            401 => 'T',
            421 => 'U',
            441 => 'V',
            461 => 'W',
            481 => 'X',
            501 => 'Y',
            521 => 'Z',
        );

        // prod (actual)
        // $prefix = array(
        //     25001 => 'A',
        //     50001 => 'B',
        //     75001 => 'C',
        //     100001 => 'D',
        //     125001 => 'E',
        //     150001 => 'F',
        //     175001 => 'G',
        //     200001 => 'H',
        // );

        foreach ($prefix as $lower_limit => $letter) {
            $upper_limit = $lower_limit + 20; // change this to actual 
    
            if ($iteration >= $lower_limit && $iteration <= $upper_limit) {
                return $letter;
            }
        }
        return null; 
    }

    public static function get_product_assembly_ids() 
    {
        // Return must be array only
        return TransactionType::where('name', 'LIKE', '%product pack%')
                                    ->orWhere('name', 'LIKE', '%uno cafe%')
                                    ->pluck('id')->toArray();
    }

    public static function get_batch_id($item_code)
    {
        $param = '/api/resource/Batch?filters=[["item", "=", "' . $item_code . '"]]&fields=["batch_id", "item_name","item","expiry_date","batch_qty"]';
                    
        $batches = Helper::get_erpnext_data($param);

        if($batches->getStatusCode() == 200) {
            $data = json_decode($batches->getBody()->getContents(), true);

            // Get the current date
            $current_date = date('Y-m-d');

            // Initialize variables to track the nearest expiry date and corresponding batch ID
            $nearest_expiry_date = null;
            $nearest_batch_id = null;

            // Iterate through the data to find the nearest expiry date
            foreach ($data['data'] as $batch) {
                $expiry_date = $batch['expiry_date'];

                // Check if the expiry date is after the current date and find the nearest one
                if ($expiry_date >= $current_date) {
                    if ($nearest_expiry_date === null || $expiry_date < $nearest_expiry_date) {
                        $nearest_expiry_date = $expiry_date;
                        $nearest_batch_id = $batch['batch_id'];
                    }
                }
            }

            return $nearest_batch_id;
        } 
        
        return 'ERROR';
    }

    public static function get_upc_ubc_transaction_ids() 
    {
        // Return must be array only
        return TransactionType::where('name', 'LIKE', '%ubc%')
                                    ->orWhere('name', 'LIKE', '%upc%')
                                    ->pluck('id')->toArray();
    }

    public static function get_is_cash_payment_names()
    {
        // Return must be array only
        return PaymentMethod::whereIsCash(1)->whereDeleted(0)->pluck('name')->toArray();
    }

    public static function get_nuc_status($status_id)
    {
        switch($status_id) {
            case 1: 
                return '<span class="badge bg-success">Credited</span>';
            case 2: 
                return '<span class="badge bg-danger">Cancelled</span>';
            case 3: 
                return '<span class="badge bg-warning">On-hold</span>';
            default: 
                return '';
        }
    }
}