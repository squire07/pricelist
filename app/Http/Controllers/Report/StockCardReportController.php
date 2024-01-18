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

class StockCardReportController extends Controller
{
    public function __construct()
    {
        $this->active_companies = Company::whereStatusId(8)->pluck('id');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sales::leftJoin('sales_details as sd', 'sd.sales_id', '=', 'sales.id')
                        ->join('sales_invoice_assignment_details as siad', 'siad.id', '=', 'sales.si_assignment_id')
                        ->select('sales.id', 'sales.updated_at', 'sales.bcid', 'sales.distributor_name', 'sd.item_code', 'sd.item_name', 'siad.prefix_value', 'siad.series_number', 'sd.quantity')
                        ->orderBy('sd.item_name')
                        ->get();

        $companies = Company::whereStatusId(8)
                        ->when(!in_array(Auth::user()->role_id, [11, 12]), function ($query) {
                            $query->where(function ($subquery) {
                                $subquery->whereRaw('FIND_IN_SET(?, id)', [Auth::user()->company_id]);
                            });
                        })
                        ->orderBy('name')->get();

        $branches = Branch::whereStatusId(8)
                        ->when(!in_array(Auth::user()->role_id, [11, 12]), function($query) {
                            $query->whereIn('id', [Auth::user()->branch_id]);
                        })
                        ->orderBy('name')->get();
        
        $transaction_types = TransactionType::whereDeleted(0)
                                ->whereIsActive(1)
                                ->orderBy('name')->get();

        return view('report.stock_card.index', compact('companies', 'branches', 'transaction_types'));
    }

    public function generate(Request $request)
    {
        // dd($request->branch_id/);
        if($request->branch_id == null) {
            $branch_ids = Branch::whereStatusId(8)
                            ->when(!in_array(Auth::user()->role_id, [11, 12]), function($query) {
                                $query->where(function ($query) {
                                    $query->whereIn('id', [Auth::user()->branch_id]);
                                });
                            })
                            ->get('id')->toArray();
        } else {
            $branch_ids = $request->branch_id;
        }

        // `as of` definition
        // first day of the month + the selected date 
        $selected_date = Carbon::createFromFormat('m/d/Y', $request->as_of);
        $date_1 = $selected_date->format('Y') . '-' . $selected_date->format('m') . '-01 00:00:00';
        $date_2 = $selected_date->format('Y-m-d') . ' 23:59:59';

        // released
        // eloquent with raw query definition
        $sales = Sales::leftJoin('sales_details as sd', 'sd.sales_id', '=', 'sales.id')
                        ->join('sales_invoice_assignment_details as siad', 'siad.id', '=', 'sales.si_assignment_id')
                        ->select('sales.id', 'sales.updated_at', 'sales.bcid', 'sales.distributor_name', 'sd.item_code', 'sd.item_name', 'siad.prefix_value', 'siad.series_number', 'sd.quantity')
                        ->where(function ($query) use ($request, $date_1, $date_2, $branch_ids) {
                            if ($request->has('company_id') && $request->company_id != null) {
                                $query->where('company_id', $request->company_id);
                            }
                            if($request->has('branch_id') && $request->branch_id != null) {
                                $query->whereIn('branch_id', [$branch_ids]);
                            }
                            if($request->has('transaction_type_id') && $request->transaction_type_id != null) {
                                $query->where('transaction_type_id', $request->transaction_type_id);
                            }
                            if($request->has('as_of') && $request->as_of !== null) {
                                $query->whereBetween('sales.updated_at', [$date_1, $date_2]);
                            }
                        })
                        ->orderBy('sd.item_name')
                        ->get();

        $stock_card_for = $request->branch_id == null ? 'All Branches' : Helper::get_branch_name_by_id($request->branch_id);
        $as_of = $request->as_of ?? Carbon::now()->format('m/d/Y');
        $transaction_type = $request->transaction_type_id == null ? 'Transaction Type: All' : Helper::get_transaction_type_name_by_id($request->transaction_type_id);

        $templatePath = public_path('excel_templates/stock-card-report-template.xlsx');
        $spreadsheet = IOFactory::load($templatePath);


        // Create a new Spreadsheet instance
        $new_spreadsheet = new Spreadsheet();
        $sheet = $new_spreadsheet->getActiveSheet();


        // header
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A3', 'Stock Card for ' . $stock_card_for);
        $sheet->setCellValue('A4', 'As of ' . $as_of);
        $sheet->setCellValue('A5', $transaction_type);
        $sheet->setCellValue('F4', 'Date Printed: ' . Carbon::now()->format('m/d/Y h:i:s A'));

        
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
                    $sheet->setCellValue('H' . $row, $total);
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
            $sheet->setCellValue('F' . $row, $sale->prefix_value . $sale->series_number);
            $sheet->setCellValue('H' . $row, $sale->quantity);
        
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
            $sheet->setCellValue('H' . $row, $total); 
        }
        
        // Save the spreadsheet to a file
        $current_datetime = Carbon::now()->format('Y-m-d hia');
        $filename = 'Stock Card Report - ' . $current_datetime . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        // Return a download response if needed and (IMPORTANT!) delete the temporary file
        return response()->download($filename)->deleteFileAfterSend(true);
    }
}