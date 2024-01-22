<?php

namespace App\Http\Controllers;

use App\Models\Nuc;
use App\Models\User;
use App\Models\Sales;
use App\Models\Branch;
use App\Helpers\Helper;
use App\Models\Company;
use App\Models\History;
use App\Models\BuildReport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BuildReportController extends Controller
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
                        ->join('transaction_types as ttype', 'ttype.id', '=', 'sales.id')
                        ->select('sales.id', 'sales.updated_at', 'sd.item_code', 'sd.item_name', 'sd.quantity', 'ttype.name')
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
        

        return view('buildreport.index', compact('companies', 'branches','sales'));
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

        // eloquent with raw query definition
        $sales = DB::table('sales as s')
                    ->select('s.id', 's.transaction_type_id', 's.updated_at', 't.name','sd.item_code', 'sd.item_name', DB::raw('SUM(sd.quantity) as quantity'))
                    ->leftJoin('sales_details as sd', 'sd.sales_id', '=', 's.id')
                    ->join('transaction_types as t', 't.id', '=', 's.transaction_type_id')
                    ->where(function ($query) use ($request, $branch_ids) {
                            if ($request->has('company_id') && $request->company_id != null) {
                                $query->where('company_id', $request->company_id);
                            }
                            if($request->has('branch_id') && $request->branch_id != null) {
                                $query->whereIn('branch_id', [$branch_ids]);
                            }
                        })
                    ->where('s.deleted', 0)
                    ->whereIn('s.status_id', [4, 5]) // validated and released
                    ->when($request->has('daterange') && $request->daterange !== null, function ($query) use ($request) {
                        $date = explode(' - ', $request->daterange);
                        $from = date('Y-m-d', strtotime($date[0])) . ' 00:00:00';
                        $to = date('Y-m-d', strtotime($date[1])) . ' 23:59:59';
                        $query->whereBetween('s.updated_at', [$from, $to]);
                    })
                    ->groupBy('s.id', 't.name', 's.updated_at', 'sd.item_name', 's.transaction_type_id', 'sd.item_code')
                    ->orderBy('t.name', 'asc')
                    ->orderBy('sd.item_name', 'asc')
                    ->get();

        $item_build_for = $request->branch_id == null ? 'All Branches' : Helper::get_branch_name_by_id($request->branch_id);
        $daterange = $request->daterange ?? Carbon::now()->format('m/d/Y');
        $company = $request->company_id !== null ? Helper::get_company_names_by_id($request->company_id) : null;

        $templatePath = public_path('excel_templates/item-build-report-template.xlsx');
        $spreadsheet = IOFactory::load($templatePath);


        // Create a new Spreadsheet instance
        $new_spreadsheet = new Spreadsheet();
        $sheet = $new_spreadsheet->getActiveSheet();


        // header
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $company);
        $sheet->setCellValue('A3', 'Item Build Report for ' . $item_build_for);
        $sheet->setCellValue('A4', 'Date: ' . $daterange);
     
        $sheet->setCellValue('F3', 'Date Printed: ' . Carbon::now()->format('m/d/Y h:i:s A'));

        // body; Starts as A6
        $unique_items = [];
        $row = 6; // Initialize $row
        
        foreach ($sales as $ks => $sale) {
            // Check if the current item_name is not in the list of displayed item_names
            if (!in_array($sale->item_code, $unique_items)) {
                // Display the item_code
                $sheet->setCellValue('A' . $row, $sale->item_code);
                $sheet->getStyle('A' . $row)->getFont()->setBold(true); // Make item_code bold
                $row++; // Move to the next row
        
                // Display each corresponding transaction type and calculate total quantity for each transaction type
                $unique_transaction_names = [];
                foreach ($sales as $inner_sale) {
                    if ($inner_sale->item_code == $sale->item_code && !in_array($inner_sale->name, $unique_transaction_names)) {
                        $total_transaction_name = 0;
                        foreach ($sales as $inner_sale2) {
                            if ($inner_sale2->item_code == $sale->item_code && $inner_sale2->name == $inner_sale->name) {
                                $total_transaction_name += $inner_sale2->quantity;
                            }
                        }
        
                        $sheet->setCellValue('B' . $row, $inner_sale->name);
                        $sheet->setCellValue('I' . $row, $total_transaction_name);
                        $unique_transaction_names[] = $inner_sale->name;
                        $row++; // Move to the next row
                    }
                }

                $sheet->setCellValue('H' . $row, 'Total');
                $sheet->getStyle('H' . $row)->getFont()->setBold(true);
        
                // Sum the quantity for each unique item_code
                $total_item_code = 0;
                foreach ($sales as $inner_sale) {
                    if ($inner_sale->item_code == $sale->item_code) {
                        $total_item_code += $inner_sale->quantity;
                    }
                }
        
                $sheet->setCellValue('I' . $row, $total_item_code);
                $sheet->getStyle('I' . $row)->getFont()->setBold(true);
                $row++; // Move to the next row
        
                // Add the item_code to the list of displayed item_codes
                $unique_items[] = $sale->item_code;
            }
        }
        
        // Save the spreadsheet to a file
        $current_datetime = Carbon::now()->format('Y-m-d hia');
        $filename = 'Item Build Report - ' . $current_datetime . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path() . '/app/public/' . $filename);
        
        // Return a download response if needed and (IMPORTANT!) delete the temporary file
        return response()->download(storage_path() . '/app/public/' . $filename)->deleteFileAfterSend(true);
    }
}