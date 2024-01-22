<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;
use App\Models\Company;
use App\Models\Branch;
use App\Models\Sales;
use App\Models\TransactionType;
use App\Helpers\Helper;
use Auth;
use Illuminate\Support\Facades\DB;

class StockCardReportController extends Controller
{
    public function __construct()
    {
        $this->active_companies = Company::whereStatusId(8)->pluck('id');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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

        return view('report.stock_card.index', compact('companies', 'branches', 'transaction_types'));
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
        $sales = Sales::leftJoin('sales_details as sd', 'sd.sales_id', '=', 'sales.id')
                        ->join('sales_invoice_assignment_details as siad', 'siad.id', '=', 'sales.si_assignment_id')
                        ->join('distributors as d', 'd.bcid', '=', DB::raw('LPAD(sales.bcid, 12, "0")'))
                        ->select('sales.id', 'sales.updated_at', 'sales.bcid', 'sales.distributor_name', 'sd.item_code', 'sd.item_name', 'siad.prefix_value', 'siad.series_number', 'sd.quantity', 'd.group', 'd.subgroup')
                        ->where(function ($query) use ($request, $date_1, $date_2) {
                            if($request->has('transaction_type_id') && $request->transaction_type_id != null) {
                                $query->where('transaction_type_id', $request->transaction_type_id);
                            }
                            if($request->has('as_of') && $request->as_of !== null) {
                                $query->whereBetween('sales.invoiced_at', [$date_1, $date_2]);
                            }
                        })
                        ->where(function ($query) use ($request, $company_ids) {
                            $query->whereIn('sales.company_id', explode(',', $company_ids));
                        })
                        ->where(function ($query) use ($request, $branch_ids) {
                            $query->whereIn('sales.branch_id', explode(',', $branch_ids));
                        })
                        ->where('status_id', 4) // released
                        ->orderBy('sd.item_name', 'asc')
                        ->orderBy('sales.updated_at', 'asc')
                        ->get();

        $stock_card_for = $request->branch_id == null ? 'All Branches' : Helper::get_branch_name_by_id($request->branch_id);
        $as_of = $request->as_of ?? Carbon::now()->format('m/d/Y');
        $transaction_type = $request->transaction_type_id == null ? 'Transaction Type: All' : Helper::get_transaction_type_name_by_id($request->transaction_type_id);

        if($request->company_id == 2) {
            $templatePath = public_path('excel_templates/stock-card-report-template-pr.xlsx');
        } elseif($request->company_id == 3) {
            $templatePath = public_path('excel_templates/stock-card-report-template-lo.xlsx');
        } else {
            $templatePath = public_path('excel_templates/stock-card-report-template.xlsx');
        }
        $spreadsheet = IOFactory::load($templatePath);


        // Create a new Spreadsheet instance
        $new_spreadsheet = new Spreadsheet();
        $sheet = $new_spreadsheet->getActiveSheet();


        // header
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A3', 'Stock Card for ' . $stock_card_for);
        $sheet->setCellValue('A4', $a4_title);
        $sheet->setCellValue('A5', $transaction_type);
        $sheet->setCellValue('H4', 'Date Printed: ' . Carbon::now()->format('m/d/Y h:i:s A'));
        $sheet->setCellValue('H5', 'Prepared By: ' . Auth::user()->name);

        
        // body; Starts as A8
        $previous_item_name = null;
        $row = 8;
        $total = 0;
        foreach ($sales as $ks => $sale) {
            // Check if the current item_name is different from the previous one
            if ($sale->item_name != $previous_item_name) {
                // Insert a row for the total before each new item name
                if ($previous_item_name !== null) {
                    // $row++;
                    $sheet->setCellValue('B' . $row, 'Total');
                    $sheet->getStyle('B' . $row)->getFont()->setBold(true); // Make total item name bold
                    $sheet->setCellValue('J' . $row, $total);
                    $total = 0;
        
                    // Add space below total
                    $row++;
                }
        
                $row++;
                $sheet->setCellValue('A' . $row, $sale->item_name);
                $sheet->getStyle('A' . $row)->getFont()->setBold(true); // Make item name bold
                $row++; // Move to the next row for data
            }
        
            // Insert rows for data
            $sheet->insertNewRowBefore($row, 1);
            $sheet->setCellValue('A' . $row, date('m/d/Y', strtotime($sale->updated_at)))->getStyle('A' . $row)->getFont()->setBold(false); 
            $sheet->setCellValue('B' . $row, $sale->distributor_name);
            $sheet->setCellValue('F' . $row, $sale->group);
            $sheet->setCellValue('G' . $row, $sale->subgroup);
            $sheet->setCellValue('H' . $row, $sale->prefix_value . $sale->series_number);
            $sheet->setCellValue('J' . $row, $sale->quantity);
        
            // Update total
            $total += $sale->quantity;
        
            $row++; // Move to the next row
            $previous_item_name = $sale->item_name;
        }
        
        // Insert the last total
        if ($previous_item_name !== null) {
            // $row++;
            $sheet->setCellValue('B' . $row, 'Total');
            $sheet->getStyle('B' . $row)->getFont()->setBold(true); // Make last total item name bold
            $sheet->setCellValue('J' . $row, $total); 
        }
        
        // Save the spreadsheet to a file
        $current_datetime = Carbon::now()->format('Y-m-d hia');
        $filename = 'Stock Card Report - ' . $current_datetime . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path() . '/app/public/' . $filename);

        // Return a download response if needed and (IMPORTANT!) delete the temporary file
        return response()->download(storage_path() . '/app/public/' . $filename)->deleteFileAfterSend(true);
    }
}