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
use App\Models\Item;
use App\Models\ItemBundle;
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

        // eloquent with raw query definition
        $sales = DB::table('sales as s')
                ->select(
                    's.id',
                    's.transaction_type_id',
                    's.updated_at',
                    'sd.item_code',
                    DB::raw('IFNULL(ib.item_description, sd.item_name) AS item_name'),
                    'sd.item_name AS original_item_name',
                    'ib.item_code',
                    'ib.item_description',
                    DB::raw('CASE
                        WHEN ib.item_description IS NOT NULL THEN COALESCE(ib.quantity, 0)
                        ELSE COALESCE(SUM(sd.quantity), 0)
                    END AS quantity'),
                    DB::raw('COALESCE(SUM(CASE WHEN ib.bundle_name IS NOT NULL THEN sd.quantity ELSE 0 END), 0) AS quantity_from_sales_details'),
                    DB::raw('(CASE
                        WHEN ib.item_description IS NOT NULL THEN COALESCE(ib.quantity, 0)
                        ELSE COALESCE(SUM(sd.quantity), 0)
                    END) * COALESCE(SUM(CASE WHEN ib.bundle_name IS NOT NULL THEN sd.quantity ELSE 0 END), 0) AS total_quantity')
                )
                ->leftJoin('sales_details as sd', 'sd.sales_id', '=', 's.id')
                ->leftJoin('item_bundles as ib', 'ib.bundle_name', '=', 'sd.item_code')
                ->where(function ($query) use ($request, $branch_ids, $date_1, $date_2) {
                    if ($request->has('as_of') && $request->as_of !== null) {
                        $query->whereBetween('s.updated_at', [$date_1, $date_2]);
                    }
                })
                ->where(function ($query) use ($request, $company_ids) {
                    $query->whereIn('s.company_id', explode(',', $company_ids));
                })
                ->where(function ($query) use ($request, $branch_ids) {
                    $query->whereIn('s.branch_id', explode(',', $branch_ids));
                })
                ->whereIn('status_id', [4,5])
                ->groupBy('s.id', 's.transaction_type_id', 's.updated_at', 'sd.item_code', 'item_name', 'ib.item_code', 'ib.item_description', 'ib.quantity')
                ->get();

        foreach ($sales as $sale) {
        $sale->item_name = str_replace('&amp;', '&', $sale->item_name);
        }

        $transaction_types = TransactionType::whereDeleted(0)
                            ->whereIsActive(1)
                            ->orderBy('id')
                            ->get();

        $item_build_for = $request->branch_id == null ? 'All Branches' : Helper::get_branch_name_by_id($request->branch_id);
        $company = $request->company_id !== null ? Helper::get_company_names_by_id($request->company_id) : null;

        if ($request->company_id == 2) {
            $templatePath = public_path('excel_templates/item-build-report-template-pr.xlsx');
        } elseif ($request->company_id == 3) {
            $templatePath = public_path('excel_templates/item-build-report-template-lo.xlsx');
        } else {
            $templatePath = public_path('excel_templates/item-build-report-template.xlsx');
        }
        
        $spreadsheet = IOFactory::load($templatePath);


        // Create a new Spreadsheet instance
        $new_spreadsheet = new Spreadsheet();
        $sheet = $new_spreadsheet->getActiveSheet();


        // header
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $company);
        $sheet->setCellValue('A3', 'Item Build Report for ' . $item_build_for);
        $sheet->setCellValue('A4', $a4_title);
        $sheet->setCellValue('H3', 'Date Printed: ' . Carbon::now()->format('m/d/Y h:i:s A'));
        $sheet->setCellValue('H4', 'Prepared By: ' . Auth::user()->name);

        // body; Starts as A7
        $row = 7; // Initialize $row

        // Display transaction types in row 6 starting from column B horizontally
        $transaction_type_column = 'B';
        foreach ($transaction_types as $transaction_type) {
            $sheet->setCellValue($transaction_type_column . '6', $transaction_type->name);
            $sheet->getStyle($transaction_type_column . '6')->getFont()->setBold(true);
            $transaction_type_column++;
        }

        $items = Item::whereDeleted(false)
                ->where(function ($query) {
                    $query->where('name', 'not like', '%PACKAGE%')
                        ->where('name', 'not like', '%PACKAGES%')
                        ->where('name', 'not like', '%12OZ%')
                        ->where('name', 'not like', '%12 OZ%')
                        ->where('name', 'not like', '%16OZ%')
                        ->where('name', 'not like', '%22OZ%')
                        ->where('name', 'not like', '%PRINTER%')
                        ->where('name', 'not like', '%APPLICATION%')
                        ->where('name', 'not like', '%CARD%')
                        ->where('name', 'not like', '%BETADINE%')
                        ->where('name', 'not like', '%INKJET%')
                        ->where('name', 'not like', '%SWITCH%');
                })
                ->whereNot('transaction_type_id', 50)
                ->orderBy('name')
                ->get();
                
        $sheet->setCellValue($transaction_type_column . '6', 'TOTAL');
        $sheet->getStyle($transaction_type_column . '6')->getFont()->setBold(true);
        $sheet->getStyle($transaction_type_column . '6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $item_names = collect($items)->pluck('name')->unique()->values(); //get a unique list of item names from the $sales set
        foreach ($item_names as $item_name) {
            // Display the item_name
            $sheet->setCellValue('A' . $row, $item_name);
            $item_name_row = $row;

            $quantity_column = 'B';
            $total_quantity = 0;

            foreach ($transaction_types as $transaction_type) {
                //get the quantity for a specific combination of item_name and transaction_type_id from the $sales.
                //$quantity = collect($sales)->where('item_name', $item_name)->where('transaction_type_id', $transaction_type->id)->first()->quantity ?? 0;
                $quantity = collect($sales)
                    ->where('item_description', $item_name)
                    ->where('transaction_type_id', $transaction_type->id)
                    ->sum('total_quantity');

                if ($quantity > 0) {
                    $sheet->setCellValue($quantity_column . $item_name_row, $quantity);
                    $sheet->getStyle($quantity_column . $item_name_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                } else {
                    $sheet->setCellValue($quantity_column . $item_name_row, '-');
                    $sheet->getStyle($quantity_column . $item_name_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                }


                $total_quantity += $quantity;
                $quantity_column++;
            }
            
            if ($total_quantity > 0) {
                $sheet->setCellValue($quantity_column . $item_name_row, $total_quantity);
            } else {
                $sheet->setCellValue($quantity_column . $item_name_row, '0');
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
    
    public function generateCafe(Request $request)
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

        // eloquent with raw query definition
        $sales = DB::table('sales as s')
                ->select(
                    's.id',
                    's.transaction_type_id',
                    's.updated_at',
                    'sd.item_code',
                    DB::raw('IFNULL(ib.item_description, sd.item_name) AS item_name'),
                    'sd.item_name AS original_item_name',
                    'ib.item_code',
                    'ib.item_description',
                    DB::raw('CASE
                        WHEN ib.item_description IS NOT NULL THEN COALESCE(ib.quantity, 0)
                        ELSE COALESCE(SUM(sd.quantity), 0)
                    END AS quantity'),
                    DB::raw('COALESCE(SUM(CASE WHEN ib.bundle_name IS NOT NULL THEN sd.quantity ELSE 0 END), 0) AS quantity_from_sales_details'),
                    DB::raw('(CASE
                        WHEN ib.item_description IS NOT NULL THEN COALESCE(ib.quantity, 0)
                        ELSE COALESCE(SUM(sd.quantity), 0)
                    END) * COALESCE(SUM(CASE WHEN ib.bundle_name IS NOT NULL THEN sd.quantity ELSE 0 END), 0) AS total_quantity')
                )
                ->leftJoin('sales_details as sd', 'sd.sales_id', '=', 's.id')
                ->leftJoin('item_bundles as ib', 'ib.bundle_name', '=', 'sd.item_code')
                ->where(function ($query) use ($request, $date_1, $date_2) {
                    if ($request->has('as_of') && $request->as_of !== null) {
                        $query->whereBetween('s.updated_at', [$date_1, $date_2]);
                    }
                })
                ->where(function ($query) use ($request, $company_ids) {
                    $query->whereIn('s.company_id', explode(',', $company_ids));
                })
                ->whereIn('status_id', [4,5])
                ->groupBy('s.id', 's.transaction_type_id', 's.updated_at', 'sd.item_code', 'item_name', 'ib.item_code', 'ib.item_description', 'ib.quantity')
                ->get();

        $transaction_types = TransactionType::whereDeleted(0)
                            ->whereIsActive(1)
                            ->orderBy('id')
                            ->get();

        $templatePath = public_path('excel_templates/item-build-report-template-cafe.xlsx');
        $spreadsheet = IOFactory::load($templatePath);


        // Create a new Spreadsheet instance
        $new_spreadsheet = new Spreadsheet();
        $sheet = $new_spreadsheet->getActiveSheet();


        // header
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A4', $a4_title);
        $sheet->setCellValue('D3', 'Date Printed: ' . Carbon::now()->format('m/d/Y h:i:s A'));
        $sheet->setCellValue('D4', 'Prepared By: ' . Auth::user()->name);

        // body; Starts as A7
        $row = 7; // Initialize $row

        // Display transaction types in row 6 starting from column B horizontally
        $transaction_ids = [38, 39, 40, 41, 42];
        $transaction_type_column = 'C';
        
        foreach ($transaction_types as $transaction_type) {
            // Check if the current transaction_type_id is in the allowed set
            if (in_array($transaction_type->id, $transaction_ids)) {
                $sheet->setCellValue($transaction_type_column . '6', $transaction_type->name);
                $sheet->getStyle($transaction_type_column . '6')->getFont()->setBold(true);
                $transaction_type_column++;
            }
        }

        $items = ItemBundle::whereDeleted(false)
                ->where(function ($query) {
                    $query->where('bundle_description', 'not like', '%PACKAGES%')
                        ->where('bundle_description', 'not like', '%PACKAGE%')
                        ->where('bundle_description', 'not like', '%PERSONALCARE%')
                        ->where('bundle_description', 'not like', '%WHITENING%');
                })
                ->orderBy('id')
                ->get();
                
        $sheet->setCellValue($transaction_type_column . '6', 'TOTAL');
        $sheet->getStyle($transaction_type_column . '6')->getFont()->setBold(true);
        $sheet->getStyle($transaction_type_column . '6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $item_names = collect($items)->pluck('item_description')->unique()->values(); //get a unique list of item names from the $sales set

        // Iterate through each unique item name
        foreach ($item_names as $item_name) {
            // Get unique UOM values for the current item
            $item_uom = collect($items)->where('item_description', $item_name)->pluck('uom')->unique()->values();

            // Display the item_name
            $sheet->setCellValue('A' . $row, $item_name);

            // Convert the collection to an array before using implode
            $item_uom_array = $item_uom->all();

            // Display the UOM values for the current item in column B
            $sheet->setCellValue('B' . $row, implode(', ', $item_uom_array));
            $item_name_row = $row;

            $quantity_column = 'C';
            $total_quantity = 0;

            foreach ($transaction_types as $transaction_type) {
                //get the quantity for a specific combination of item_name and transaction_type_id from the $sales.
                if (in_array($transaction_type->id, $transaction_ids)) {
                // $quantity = collect($sales)->where('item_description', $item_name)->where('transaction_type_id', $transaction_type->id)->first()->quantity ?? 0;
                $quantity = collect($sales)
                    ->where('item_description', $item_name)
                    ->where('transaction_type_id', $transaction_type->id)
                    ->sum('total_quantity');

                if ($quantity > 0) {
                    $sheet->setCellValue($quantity_column . $item_name_row, $quantity);
                    $sheet->getStyle($quantity_column . $item_name_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                } else {
                    $sheet->setCellValue($quantity_column . $item_name_row, '-');
                    $sheet->getStyle($quantity_column . $item_name_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                }

                $total_quantity += $quantity;
                $quantity_column++;
                }
            }
            
            if ($total_quantity > 0) {
                $sheet->setCellValue($quantity_column . $item_name_row, $total_quantity);
            } else {
                $sheet->setCellValue($quantity_column . $item_name_row, '0');
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