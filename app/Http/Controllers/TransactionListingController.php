<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sales;
use App\Models\Branch;
use App\Helpers\Helper;
use App\Models\Company;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\TransactionType;
use App\Models\TransactionListing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TransactionListingController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->active_companies = Company::whereStatusId(8)->pluck('id');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_branch = User::whereId(Auth::user()->id)->value('branch_id'); 

        $sales = Sales::leftJoin('sales_details as sd', 'sd.sales_id', '=', 'sales.id')
                        ->join('sales_invoice_assignment_details as siad', 'siad.id', '=', 'sales.si_assignment_id')
                        ->select('sales.id', 'sales.updated_at', 'sales.bcid', 'sales.distributor_name', 'sd.item_code', 'sd.item_name', 'siad.prefix_value', 'siad.series_number', 'sd.quantity')
                        ->orderBy('sd.item_name')
                        ->get();

        $companies = Company::whereStatusId(8)
                        ->where(function ($query) {
                            if(Auth::user()->company_id !== null) { // users with company ids
                                $query->whereIn('id', explode(',',Auth::user()->company_id));
                            }
                        })
                        ->orderBy('name')->get();

        $branches = Branch::whereStatusId(8)
                        ->where(function ($query) {
                            if(Auth::user()->branch_id !== null) { // users with branch ids
                                $query->whereIn('id', explode(',',Auth::user()->branch_id));
                            }
                        })
                        ->orderBy('name')->get();

        $transaction_types = TransactionType::whereDeleted(0)
                                ->whereIsActive(1)
                                ->orderBy('name')->get();

        $cashiers = User::whereDeleted(false)
                        ->where(function ($query) {
                            if(Auth::user()->branch_id !== null) { // users with branch ids
                                $query->whereIn('id', explode(',',Auth::user()->branch_id));
                            }
                        })
                        ->whereIn('role_id', [2,4])
                        ->orderBy('name')
                        ->get();
 

        $items = Item::whereDeleted(false)
                        ->orderBy('id')
                        ->select('name')
                        ->distinct()
                        ->get();

        return view('transactionlisting.index', compact('companies', 'branches', 'transaction_types', 'items', 'cashiers'));
    }

    public function generate(Request $request)
    {
        $a4_title = null;
        $date_1 = null;
        $date_2 = null;
        if($request->as_of_report != null) {
            // `as of` definition
            // first day of the month + the selected date 
            $selected_date = Carbon::createFromFormat('m/d/Y', $request->as_of);
            $date_1 = $selected_date->format('Y') . '-' . $selected_date->format('m') . '-01 00:00:00';
            $date_2 = $selected_date->format('Y-m-d') . ' 23:59:59';

            $a4_title = 'As of ' . $selected_date->format('m/d/Y');
        } else {
            list($startDate, $endDate) = explode(' - ', $request->period);

            // Parse the start and end dates using Carbon
            $request_date_1 = Carbon::createFromFormat('m/d/Y h:i A', trim($startDate));
            $date_1 = $request_date_1->format('Y-m-d H:i:s');
            $request_date_2 = Carbon::createFromFormat('m/d/Y h:i A', trim($endDate));
            $date_2 = $request_date_2->format('Y-m-d H:i:59');

            $a4_title = 'Period of ' . $request->period;
        }
        $company_ids = '';
        if($request->company_id != NULL) {
            $company_ids = $request->company_id;
        } else if ($request->company_id == NULL && Auth::user()->company_id == NULL) {
            $active_companies = Company::where('deleted', false)->where('status_id', 8)->pluck('id')->toArray();
            $company_ids = implode(',',$active_companies);
        } else if ($request->company_id == NULL && Auth::user()->company_id != NULL) {
            $company_ids = Auth::user()->company_id;
        }

        $branch_ids = '';
        if($request->branch_id != NULL) {
            $branch_ids = $request->branch_id;
        } else if ($request->branch_id == NULL && Auth::user()->branch_id == NULL) {
            $active_branches = Branch::where('deleted', false)->where('status_id', 8)->pluck('id')->toArray();
            $branch_ids = implode(',',$active_branches);
        } else if ($request->branch_id == NULL && Auth::user()->branch_id != NULL) {
            $branch_ids = Auth::user()->branch_id;
        }

        // released
        // eloquent with raw query definition
        $sales = DB::table('sales')
                ->select(
                    'sales.id',
                    't.name as transaction_type_name',
                    'sales.invoiced_at',
                    'sales.bcid',
                    'sales.distributor_name',
                    'sd.item_name',
                    'ib.item_description',
                    'sd.amount',
                    'sd.quantity',
                    'p.payment_type',
                    'b.cost_center',
                    DB::raw("IFNULL(JSON_UNQUOTE(JSON_EXTRACT(p.details, '$[0].ref_no')), 'N/A') AS ref_no"),
                    'p.created_by as cashier',
                    DB::raw("CONCAT(COALESCE(siad.prefix_value, ''), COALESCE(siad.series_number, '')) AS invoice_number"),
                    DB::raw('SUBSTRING(iea.income_account, 1, 7) AS income_account_code'),
                    'iea.income_account',
                    'pm.code AS payment_code',
                    'pm.description AS payment_description'
                )
                ->join('income_expense_accounts as iea', 'iea.id', '=', 'sales.id')
                ->join('transaction_types as t', 't.id', '=', 'sales.id')
                ->leftJoin('sales_details as sd', 'sd.sales_id', '=', 'sales.id')
                ->leftJoin('sales_invoice_assignment_details as siad', 'sales.si_assignment_id', '=', 'siad.id')
                ->leftJoin('payments as p', 'p.sales_id', '=', 'sales.id')
                ->leftJoin('branches as b', 'b.id', '=', 'sales.branch_id')
                ->leftJoin('payment_methods as pm', 'sales.id', '=', 'pm.id')
                ->leftJoin('item_bundles as ib', 'ib.bundle_name', '=', 'sd.item_code')
                ->where(function ($query) use ($request, $date_1, $date_2) {
                    if($request->has('transaction_type_id') && $request->transaction_type_id != null) {
                        $query->where('sales.transaction_type_id', $request->transaction_type_id);
                    }
                    if ($request->has('as_of') && $request->as_of !== null) {
                        $query->whereBetween('sales.invoiced_at', [$date_1, $date_2]);
                    }
                    if ($request->has('period') && $request->period !== null) {
                        $query->whereBetween('sales.invoiced_at', [$date_1, $date_2]);
                    }
                    if ($request->has('item') && $request->item != null) {
                        $query->where(function ($query) use ($request) {
                            $query->where('sd.item_name', $request->item)
                                  ->orWhere('ib.item_description', 'LIKE', '%' . $request->item . '%');
                        });
                    }
                    if ($request->has('invoice') && $request->invoice != null) {
                        $query->where(DB::raw("CONCAT(COALESCE(siad.prefix_value, ''), COALESCE(siad.series_number, ''))"), $request->invoice);
                    }
                    if ($request->has('cashier') && $request->cashier != null) {
                        $query->where('p.created_by', $request->cashier);
                    }
                })
                ->where(function ($query) use ($request, $company_ids) {
                    $query->whereIn('sales.company_id', explode(',', $company_ids));
                })
                ->where(function ($query) use ($request, $branch_ids) {
                    $query->whereIn('sales.branch_id', explode(',', $branch_ids));
                })
                ->orderBy('sales.id')
                ->get();

            //dd($request);

        foreach ($sales as $sale) {
        $sale->item_name = str_replace('&amp;', '&', $sale->item_name);
        $sale->item_description = str_replace('&amp;', '&', $sale->item_description);
        }


        $translist_for = $request->branch_id == null ? 'Branch: All' : Helper::get_branch_name_by_id($request->branch_id);
        $as_of = $request->as_of ?? Carbon::now()->format('m/d/Y');
        $transaction_type = $request->transaction_type_id == null ? 'Transaction Type: All' : Helper::get_transaction_type_name_by_id($request->transaction_type_id);
        $item = $request->item == null ? 'Item: All' : 'Item : ' . ($request->item);
        $cashier = $request->cashier == null ? 'Cashier: All' : 'Cashier : ' . Helper::get_cashier_name_by_id($request->cashier);
        $invoice = $request->invoice == null ? 'Invoice #: All' : 'Invoice #: ' . ($request->invoice);

        if($request->company_id == 2) {
            $templatePath = public_path('excel_templates/transaction-list-report-template-pr.xlsx');
        } elseif($request->company_id == 3) {
            $templatePath = public_path('excel_templates/transaction-list-report-template-lo.xlsx');
        } else {
            $templatePath = public_path('excel_templates/transaction-list-report-template.xlsx');
        }
        $spreadsheet = IOFactory::load($templatePath);


        // Create a new Spreadsheet instance
        $new_spreadsheet = new Spreadsheet();
        $sheet = $new_spreadsheet->getActiveSheet();


        // header
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A3', 'Transaction List for ' . $translist_for);
        $sheet->setCellValue('A4', $a4_title);
        $sheet->setCellValue('A5', $transaction_type);
        $sheet->setCellValue('A6', $item);
        $sheet->setCellValue('A7', $cashier);
        $sheet->setCellValue('F6', $invoice);
        $sheet->setCellValue('F4', 'Date Printed: ' . Carbon::now()->format('m/d/Y h:i:s A'));
        $sheet->setCellValue('F5', 'Prepared By: ' . Auth::user()->name);

    // body; Starts as A8
    $previous_invoiced_at = null;
    $previous_invoice_number = null;
    $previous_item_names = null;
    $row = 8;

    foreach ($sales as $ks => $sale) {
        // Check if the current item_name is different from the previous one
        if ($sale->invoiced_at != $previous_invoiced_at) {
            // Insert a row for the total before each new item name
            if ($previous_invoiced_at !== null) {
                $row++;
            }
            $sheet->setCellValue('A' . $row, date('m/d/Y', strtotime($sale->invoiced_at)))->getStyle('A' . $row)->getFont()->setBold(false);
            $sheet->getStyle('A' . $row)->getFont()->setBold(true); // Make item name bold
            $row++; // Move to the next row for data
            $previous_invoiced_at = $sale->invoiced_at; // Update previous_invoiced_at
        }
    
        // Check if the current invoice_number is different from the previous one
        if ($sale->invoice_number != $previous_invoice_number) {
            // Only insert a row before invoice_number if it's not the first row
            if ($previous_invoice_number !== null) {
                $row++;
            }
            $sheet->setCellValue('B' . $row, $sale->invoice_number);
            $sheet->getStyle('B' . $row)->getFont()->setBold(true); 
            $row++; // Move to the next row for data
            $sheet->setCellValue('B' . $row, $sale->distributor_name . ' [' . $sale->bcid . ']');
    
            $previous_invoice_number = $sale->invoice_number; // Update previous_invoice_number
        }
    
        // Insert rows for data only if the item_name is different from the previous one
        if ($sale->item_name != $previous_item_names) {
            $sheet->insertNewRowBefore($row, 1);
            $sheet->setCellValue('B' . $row, $sale->item_name . ' (' . $sale->quantity . ') (' . $sale->ref_no . ')');
            $sheet->getStyle('B' . $row)->getFont()->setBold(true);
            $sheet->setCellValue('C' . $row, $sale->payment_type);
            $sheet->setCellValue('E' . $row, $sale->payment_code);
            $sheet->setCellValue('F' . $row, $sale->cost_center);
            $sheet->setCellValue('G' . $row, $sale->payment_description);

            $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->setCellValue('I' . $row, $sale->amount);

            $row++;
            $sheet->setCellValue('C' . $row, $sale->transaction_type_name);
            $sheet->setCellValue('E' . $row, $sale->income_account_code);
            $sheet->setCellValue('F' . $row, $sale->cost_center);
            $sheet->setCellValue('G' . $row, $sale->income_account);

            $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->setCellValue('J' . $row, $sale->amount);

            $row++;
            $previous_item_names = $sale->item_name; // Update previous_item_names
        }
        
            $sheet->setCellValue('B' . $row, ($sheet->getCell('B' . $row)->getValue() ? $sheet->getCell('B' . $row)->getValue() . "\n" : '') . $sale->item_description);
            $row++; // Move to the next row
        }
        
        // Additional check after the loop to make sure the last $previous_invoiced_at is displayed only once
        if ($previous_invoiced_at !== null) {
            $row++;
            $sheet->setCellValue('H' . $row, 'Total:');
            
            $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->setCellValue('I' . $row, "=SUM(I2:I" . $row . ")");
            
            $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->setCellValue('J' . $row, "=SUM(J2:J" . $row . ")");

            $sheet->getStyle('H' . $row)->getFont()->setBold(true);
            $sheet->getStyle('I' . $row)->getFont()->setBold(true);
            $sheet->getStyle('J' . $row)->getFont()->setBold(true);
        }
        // Save the spreadsheet to a file
        $current_datetime = Carbon::now()->format('Y-m-d hia');
        $filename = 'Transaction List Report - ' . $current_datetime . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path() . '/app/public/' . $filename);

        // Return a download response if needed and (IMPORTANT!) delete the temporary file
        return response()->download(storage_path() . '/app/public/' . $filename)->deleteFileAfterSend(true);
    }
}