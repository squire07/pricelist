<?php

namespace App\Http\Controllers;

use App\Models\Nuc;
use App\Models\Sales;
use App\Models\Branch;
use App\Helpers\Helper;
use App\Models\History;
use App\Models\BuildReport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BuildReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sales_orders = Nuc::with('distributor','branch')
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
                            })                       
                            ->orderByDesc('id')
                            ->where('status', 1)
                            ->get();

        $branches = Branch::whereDeleted(false)->get();
                
        return view('buildreport.index', compact('sales_orders','branches'));
    }
    public function exportToExcel(Request $request)
    {
        $filtered_sales = $this->SalesData($request);
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        $sheet->setCellValue('A1', 'Date');
        $sheet->setCellValue('B1', 'Branch');
        $sheet->setCellValue('C1', 'Invoice #');
        $sheet->setCellValue('D1', 'BCID');
        $sheet->setCellValue('E1', 'Name');
        $sheet->setCellValue('F1', 'NUC');
        $sheet->setCellValue('G1', 'Status');
    
        $font_bold = $sheet->getStyle('A1:G1')->getFont();
        $font_bold->setBold(true);
    
        $row = 2;
        $total_qty = 0;
        foreach ($filtered_sales as $sale) {
            $sheet->setCellValue('A' . $row, $sale->updated_at->format('m/d/Y'));
            $sheet->setCellValue('B' . $row, $sale->branch->name ?? null);
            $sheet->setCellValue('C' . $row, $sale->oid?? null);
            $sheet->setCellValue('D' . $row, $sale->bcid ?? null);
            $sheet->setCellValue('E' . $row, $sale->distributor->name ?? null);
            $sheet->setCellValue('F' . $row, $sale->total_nuc ?? 0);
            $sheet->setCellValue('G' . $row, $sale->status == 1 ? 'Credited' : null );
    
            $total_qty += $sale->total_nuc;

            $row++;
        }
    
        $sheet->setCellValue('E' . $row, 'Total:');
        $sheet->setCellValue('F' . $row, $total_qty);
    
        $font_bold = $sheet->getStyle('E' . $row)->getFont();
        $font_bold->setBold(true);
    
        $font_bold = $sheet->getStyle('F' . $row)->getFont();
        $font_bold->setBold(true);
    
        $filename = 'NUC_report.xlsx';
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
        $query = Nuc::where('deleted', false);
    
        if ($request->has('daterange')) {
            $date = explode(' - ', $request->daterange);
            $from = date('Y-m-d', strtotime($date[0])) . ' 00:00:00';
            $to = date('Y-m-d', strtotime($date[1])) . ' 23:59:59';
    
            $query->whereBetween('created_at', [$from, $to]);
        }
    
        if ($request->filled('branch')) {
            $query->where('branch_id', $request->input('branch'));
        }
    
        if ($request->filled('bcid')) {
            $query->where('bcid', $request->input('bcid'));
        }
    
        return $query->with(['branch'])->get();
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
    public function show(BuildReport $buildReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BuildReport $buildReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BuildReport $buildReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BuildReport $buildReport)
    {
        //
    }
}
