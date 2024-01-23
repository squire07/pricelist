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
use App\Models\TransactionType;
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

        // eloquent with raw query definition
        $sales = DB::table('sales as s')
                    ->select('s.id', 's.transaction_type_id', 's.updated_at', 't.name','sd.item_code', 'sd.item_name', DB::raw('SUM(sd.quantity) as quantity'))
                    ->leftJoin('sales_details as sd', 'sd.sales_id', '=', 's.id')
                    ->join('transaction_types as t', 't.id', '=', 's.transaction_type_id')
                    ->where(function ($query) use ($request, $branch_ids, $date_1, $date_2) {
                            if ($request->has('company_id') && $request->company_id != null) {
                                $query->where('company_id', $request->company_id);
                            }
                            if($request->has('branch_id') && $request->branch_id != null) {
                                $query->whereIn('branch_id', [$branch_ids]);
                            }
                            if($request->has('as_of') && $request->as_of !== null) {
                                $query->whereBetween('s.updated_at', [$date_1, $date_2]);
                            }
                        })
                    ->where('s.deleted', 0)
                    ->whereIn('s.status_id', [4, 5]) // validated and released
                    // ->when($request->has('daterange') && $request->daterange !== null, function ($query) use ($request) {
                    //     $date = explode(' - ', $request->daterange);
                    //     $from = date('Y-m-d', strtotime($date[0])) . ' 00:00:00';
                    //     $to = date('Y-m-d', strtotime($date[1])) . ' 23:59:59';
                    //     $query->whereBetween('s.updated_at', [$from, $to]);
                    // })
                    ->groupBy('s.id', 't.name', 's.updated_at', 'sd.item_name', 's.transaction_type_id', 'sd.item_code')
                    ->orderBy('t.name', 'asc')
                    ->orderBy('sd.item_name', 'asc')
                    ->get();

        $transaction_types = TransactionType::whereDeleted(0)
                            ->whereIsActive(1)
                            ->orderBy('id')
                            ->get();

        $item_build_for = $request->branch_id == null ? 'All Branches' : Helper::get_branch_name_by_id($request->branch_id);
        // $daterange = $request->daterange ?? Carbon::now()->format('m/d/Y');
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
        $sheet->setCellValue('A4', $a4_title);
        $sheet->setCellValue('G3', 'Date Printed: ' . Carbon::now()->format('m/d/Y h:i:s A'));

        // body; Starts as A7
        $row = 7; // Initialize $row

        // Display transaction types in row 6 starting from column B horizontally
        $transaction_type_column = 'B';
        foreach ($transaction_types as $transaction_type) {
            $sheet->setCellValue($transaction_type_column . '6', $transaction_type->name);
            $sheet->getStyle($transaction_type_column . '6')->getFont()->setBold(true);
            $transaction_type_column++;
        }

        $sheet->setCellValue($transaction_type_column . '6', 'TOTAL');
        $sheet->getStyle($transaction_type_column . '6')->getFont()->setBold(true);
        $item_names = collect($sales)->pluck('item_name')->unique()->values(); //get a unique list of item names from the $sales set
        foreach ($item_names as $item_name) {
            // Display the item_name
            $sheet->setCellValue('A' . $row, $item_name);
            $item_name_row = $row;

            $quantity_column = 'B';
            $total_quantity = 0;

            foreach ($transaction_types as $transaction_type) {
                //get the quantity for a specific combination of item_name and transaction_type_id from the $sales.
                $quantity = collect($sales)->where('item_name', $item_name)->where('transaction_type_id', $transaction_type->id)->first()->quantity ?? 0;

                if ($quantity > 0) {
                    $sheet->setCellValue($quantity_column . $item_name_row, $quantity);
                } else {
                    $sheet->setCellValue($quantity_column . $item_name_row, '-');
                    $sheet->getStyle($quantity_column)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                }

                $total_quantity += $quantity;
                $quantity_column++;
            }
            
            if ($total_quantity > 0) {
                $sheet->setCellValue($quantity_column . $item_name_row, $total_quantity);
            } else {
                $sheet->setCellValue($quantity_column . $item_name_row, '');
            }

            $sheet->getStyle($quantity_column . $item_name_row)->getFont()->setBold(true);
            $row++; // Move to the next row
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