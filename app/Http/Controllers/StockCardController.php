<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Sales;
use App\Models\Branch;
use App\Models\StockCard;
use App\Models\SalesDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\TransactionType;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Models\Company;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Font;
use App\Helpers\Helper;

class StockCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get current users branch ids 
        $user_branch = User::whereId(Auth::user()->id)->value('branch_id');

        $sales = Sales::with('sales_details', 'transaction_type', 'branch')
            ->where(function ($query) use ($request) {
                if ($request->has('daterange')) {
                    $date = explode(' - ', $request->daterange);
                    $from = date('Y-m-d', strtotime($date[0])) . ' 00:00:00';
                    $to = date('Y-m-d', strtotime($date[1])) . ' 23:59:59';
    
                    // Apply the whereBetween condition
                    $query->whereBetween('created_at', [$from, $to]);
                } else {
                    $query->whereDate('created_at', '=', now()->toDateString());
                }
    
                if ($request->filled('branch')) {
                    $query->where('branch_id', $request->input('branch'));
                }
 
                if ($request->filled('item')) {
                    $query->whereHas('sales_details', function ($subquery) use ($request) {
                        $subquery->where('item_code', $request->input('item'));
                    });
                }

                if ($request->filled('bcid')) {
                    $query->where('bcid', $request->input('bcid'));
                }
    

                if ($request->filled('transaction_type')) {
                    $query->where('transaction_type_id', $request->input('transaction_type'));
                }
            })
            ->whereIn('status_id', [4, 5])
            ->where('deleted', 0)
            ->when(!empty($user_branch), function ($query) use ($user_branch) {
                $query->whereIn('branch_id', explode(',', $user_branch));
            })
            ->get();

            $companies = Company::whereDeleted(false)->whereIn('status_id', [8,1])->get(); // 1 does not exists in status table as active/enable

            $company_ids = [];
            foreach($companies as $company) {
                $company_ids[] = $company->id;
            }
    
            // users without branch id
            $branches = Branch::whereDeleted(false)->whereIn('status_id',[8,1])->whereIn('company_id', $company_ids)->orderBy('name')->get(['id','name']);   
    
            // users with branch id
            if(!empty(Auth::user()->branch_id)) {
                $branch_ids = explode(',', Auth::user()->branch_id);
    
                $branches = Branch::whereDeleted(false)
                                ->whereIn('id', $branch_ids)
                                ->whereIn('company_id', $company_ids)
                                ->whereIn('status_id',[8,1])
                                ->get(['id','name']);
            }

        $transaction_types = TransactionType::whereDeleted(false)->get();

        $items = Item::whereDeleted(false)
        ->where('transaction_type_id', 1)
        ->get();

        return view('stockcard.index', compact('sales', 'branches', 'transaction_types', 'items'));
    }

    /**
     * Export sales data to Excel.
     */
    public function exportToExcel(Request $request)
    {
        $filtered_sales = $this->SalesData($request);
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        $sheet->setCellValue('A1', 'Date');
        $sheet->setCellValue('B1', 'Branch');
        $sheet->setCellValue('C1', 'Item');
        $sheet->setCellValue('D1', 'Transaction Type');
        $sheet->setCellValue('E1', 'Invoice No');
        $sheet->setCellValue('F1', 'BCID');
        $sheet->setCellValue('G1', 'Distributor');
        $sheet->setCellValue('H1', 'Out Qty');
    
        $font_bold = $sheet->getStyle('A1:H1')->getFont();
        $font_bold->setBold(true);
    
        $row = 2;
        $total_qty = 0;
        foreach ($filtered_sales as $sale) {
            $sheet->setCellValue('A' . $row, $sale->updated_at->format('m/d/Y'));
            $sheet->setCellValue('B' . $row, $sale->branch->name ?? null);
            $sheet->setCellValue('C' . $row, $sale->sales_details[0]['item_name'] ?? null);
            $sheet->setCellValue('D' . $row, $sale->transaction_type->name ?? null);
            $sheet->setCellValue('E' . $row, Helper::get_si_assignment_no($sale->si_assignment_id));
            $sheet->setCellValue('F' . $row, $sale->bcid ?? null);
            $sheet->setCellValue('G' . $row, Helper::get_distributor_name_by_bcid($sale->bcid) ?? null);
            $sheet->setCellValue('H' . $row, $sale->sales_details[0]['quantity'] ?? null);
    
            $total_qty += $sale->sales_details[0]['quantity'] ?? 0;
    
            $row++;
        }
    
        $sheet->setCellValue('G' . $row, 'Total:');
        $sheet->setCellValue('H' . $row, $total_qty);
    
        $font_bold = $sheet->getStyle('G' . $row)->getFont();
        $font_bold->setBold(true);
    
        $font_bold = $sheet->getStyle('H' . $row)->getFont();
        $font_bold->setBold(true);
    
        $filename = 'stock_card.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
    
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    
        exit;
    }
    /**
     * Fetch filtered sales data based on request parameters.
     */
    private function SalesData(Request $request)
    {
        $query = Sales::where('deleted', false);
    
        if ($request->has('daterange')) {
            $date = explode(' - ', $request->daterange);
            $from = date('Y-m-d', strtotime($date[0])) . ' 00:00:00';
            $to = date('Y-m-d', strtotime($date[1])) . ' 23:59:59';
    
            $query->whereBetween('created_at', [$from, $to]);
        }
    
        if ($request->filled('branch')) {
            $query->where('branch_id', $request->input('branch'));
        }
    
        if ($request->filled('item')) {
            $query->whereHas('sales_details', function ($subquery) use ($request) {
                $subquery->where('item_code', $request->input('item'));
            });
        }
    
        if ($request->filled('bcid')) {
            $query->where('bcid', $request->input('bcid'));
        }
    
        if ($request->filled('transaction_type')) {
            $query->where('transaction_type_id', $request->input('transaction_type'));
        }
    
        return $query->with(['branch', 'sales_details', 'transaction_type'])->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StockCard $stockCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockCard $stockCard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockCard $stockCard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockCard $stockCard)
    {
        //
    }

    public function stockcard_list() 
    {
        $stockcards = Sales::whereDeleted(false);
        return DataTables::of($stockcards)->toJson();
    }

}
