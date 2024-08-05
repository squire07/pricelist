<?php

namespace App\Http\Controllers;

use App\Models\Deliveries;
use App\Models\DeliveryDetails;
use Illuminate\Http\Request;
use App\Models\DeliveryReport;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Database\Query\JoinClause;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DeliveryReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deliveries = Deliveries::whereDeleted(false)
                    ->whereNot('delivery_status', 3)
                    ->get();
        
        return view('report.dr-report.index', compact('deliveries'));
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
    public function show(DeliveryReport $deliveryReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeliveryReport $deliveryReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeliveryReport $deliveryReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeliveryReport $deliveryReport)
    {
        //
    }

    public function generate(Request $request)
    {

        //dd($request);

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

        DB::enableQueryLog();

        if(isset($request->report) && $request->report == "1") {

        // eloquent with raw query definition
        $deliveries = Deliveries::where('deliveries.deleted', false)
        ->leftJoin('payments as p', function($join) {
            $join->on('p.id', '=', 'deliveries.payment_id')
                ->where('p.deleted', 0);
        })
        ->leftJoin('delivery_details as dd', function($join) {
            $join->on('dd.id', '=', 'deliveries.id')
                ->where('dd.deleted', 0);
        })
            ->select([
            'deliveries.store_name',
            DB::raw('SUM(deliveries.total_quantity) as total_quantity'),
            DB::raw('SUM(deliveries.total_amount) as total_amount'),
            DB::raw('SUM(p.total_amount_paid) as total_amount_paid'),
            DB::raw('SUM(p.balance) as balance'),
            DB::raw('SUM(p.change) as cash_change')
                ])
            ->where(function ($query) use ($request, $date_1, $date_2) {
                if ($request->has('as_of') && $request->as_of !== null) {
                    $query->whereBetween('deliveries.delivered_date', [$date_1, $date_2]);
                }
            })
            ->whereNot('deliveries.delivery_status', 3)
            ->groupBy('deliveries.store_name')
            ->orderBy('deliveries.total_amount', 'DESC')
            ->get();
        
        $templatePath = public_path('excel_templates/dr-customer-performance-report-template.xlsx');
        
        $spreadsheet = IOFactory::load($templatePath);


        // Create a new Spreadsheet instance
        $new_spreadsheet = new Spreadsheet();
        $sheet = $new_spreadsheet->getActiveSheet();

        // header
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A3', 'Date Printed: ' . Carbon::now()->format('m/d/Y h:i:s A'));
        $sheet->setCellValue('A4', 'Prepared By: ' . Auth::user()->name);
        $sheet->setCellValue('A5', $a4_title);

        // // body; Starts as A7
        $row = 8;

            foreach ($deliveries as $ks => $delivery) {
                $sheet->setCellValue('A' . $row, $delivery->store_name);
                $sheet->setCellValue('B' . $row, $delivery->total_quantity);
                $sheet->getStyle('C' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->setCellValue('C' . $row, $delivery->total_amount);
                $sheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->setCellValue('D' . $row, $delivery->total_amount_paid);
                $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->setCellValue('E' . $row, $delivery->balance);
                $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->setCellValue('F' . $row, $delivery->cash_change);
                $row++; // Move to the next set of rows for the next store
            }
        }

        if(isset($request->report) && $request->report == "2") {

            $details = DeliveryDetails::leftJoin('deliveries as d', function($join) {
                $join->on('d.id', '=', 'delivery_details.delivery_id') // Assuming there's a delivery_id in delivery_details
                    ->where('d.deleted', 0);
            })
            ->select(
                'delivery_details.item_name',
                DB::raw('SUM(delivery_details.quantity) AS total_quantity'),
                DB::raw('SUM(delivery_details.size_in_kg) AS total_size_in_kg'),
                DB::raw('SUM(delivery_details.amount) AS total_amount')
            )
            ->where(function ($query) use ($request, $date_1, $date_2) {
                if ($request->has('as_of') && $request->as_of !== null) {
                    $query->whereBetween('d.delivered_date', [$date_1, $date_2]);
                }
            })
            ->where('delivery_details.deleted', 0)
            ->groupBy('delivery_details.item_name')
            ->orderByDesc(DB::raw('total_size_in_kg'))
            ->get();
            
            
            $templatePath = public_path('excel_templates/dr-product-performance-report-template.xlsx');
            
            $spreadsheet = IOFactory::load($templatePath);
    
    
            // Create a new Spreadsheet instance
            $new_spreadsheet = new Spreadsheet();
            $sheet = $new_spreadsheet->getActiveSheet();
    
            // header
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A3', 'Date Printed: ' . Carbon::now()->format('m/d/Y h:i:s A'));
            $sheet->setCellValue('A4', 'Prepared By: ' . Auth::user()->name);
            $sheet->setCellValue('A5', $a4_title);
    
            // // body; Starts as A7
            $row = 8;
    
                foreach ($details as $ks => $detail) {
                    $sheet->setCellValue('A' . $row, $detail->item_name);
                    $sheet->setCellValue('B' . $row, $detail->total_quantity);
                    $sheet->setCellValue('C' . $row, $detail->total_size_in_kg);
                    $sheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                    $sheet->setCellValue('D' . $row, $detail->total_amount);
                    $row++; // Move to the next set of rows for the next store
                }
            }

            if(isset($request->report) && $request->report == "3") {
                // eloquent with raw query definition
                $deliveries = Deliveries::with(['deliverystatus', 'paymentstatus'])
                ->join('payments as p', function($join) {
                    $join->on('p.id', '=', 'deliveries.payment_id')
                         ->where('p.deleted', 0);
                })
                ->join('delivery_details as dd', function($join) {
                    $join->on('dd.id', '=', 'deliveries.id')
                         ->where('dd.deleted', 0);
                })
                ->join('payment_statuses', 'payment_statuses.id', '=', 'deliveries.payment_status')
                ->join('delivery_statuses', 'delivery_statuses.id', '=', 'deliveries.delivery_status')
                ->where('deliveries.deleted', 0)
                ->select(
                    'deliveries.dr_no',
                    'delivery_statuses.name as deliverystatus_name',
                    'payment_statuses.name as paymentstatus_name',
                    'delivery_date',
                    'payment_terms',
                    'due_date',
                    'delivered_date',
                    'srp_type',
                    'store_name',
                    'address',
                    'customer_category',
                    'area_group',
                    'total_quantity',
                    'add_discount',
                    'add_discount_value',
                    'deliveries.total_amount as total_amount',
                    'vatable_sales',
                    'vat_amount',
                    'grandtotal_amount',
                    'delivered_by',
                    'agents',
                    'payment_remarks'
                )
                ->where(function ($query) use ($request, $date_1, $date_2) {
                    if ($request->has('as_of') && $request->as_of !== null) {
                        $query->whereBetween('deliveries.delivered_date', [$date_1, $date_2]);
                    }
                })
                ->where('deliveries.deleted', 0)
                ->orderBy('deliveries.id')
                ->get();
                
                
                $templatePath = public_path('excel_templates/dr-details-report-template.xlsx');
                
                $spreadsheet = IOFactory::load($templatePath);
        
        
                // Create a new Spreadsheet instance
                $new_spreadsheet = new Spreadsheet();
                $sheet = $new_spreadsheet->getActiveSheet();
        
                // header
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A3', 'Date Printed: ' . Carbon::now()->format('m/d/Y h:i:s A'));
                $sheet->setCellValue('A4', 'Prepared By: ' . Auth::user()->name);
                $sheet->setCellValue('A5', $a4_title);
        
                // // body; Starts as A7
                $row = 8;
        
                    foreach ($deliveries as $ks => $delivery) {
                        $sheet->setCellValue('A' . $row, $delivery->dr_no);
                        $sheet->setCellValue('B' . $row, $delivery->deliverystatus_name);
                        $sheet->setCellValue('C' . $row, $delivery->paymentstatus_name);
                        $sheet->setCellValue('D' . $row, $delivery->delivery_date);
                        $sheet->setCellValue('E' . $row, $delivery->payment_terms);
                        $sheet->setCellValue('F' . $row, $delivery->due_date);
                        $sheet->setCellValue('G' . $row, $delivery->delivered_date);
                        $sheet->setCellValue('H' . $row, $delivery->srp_type);
                        $sheet->setCellValue('I' . $row, $delivery->store_name);
                        $sheet->setCellValue('J' . $row, $delivery->address);
                        $sheet->setCellValue('K' . $row, $delivery->customer_category);
                        $sheet->setCellValue('L' . $row, $delivery->area_group);
                        $sheet->setCellValue('M' . $row, $delivery->total_quantity);
                        $sheet->setCellValue('N' . $row, $delivery->add_discount);
                        $sheet->setCellValue('O' . $row, $delivery->add_discount_value);
                        $sheet->setCellValue('P' . $row, $delivery->total_amount);
                        $sheet->setCellValue('Q' . $row, $delivery->vatable_sales);
                        $sheet->setCellValue('R' . $row, $delivery->vat_amount);
                        $sheet->setCellValue('S' . $row, $delivery->grandtotal_amount);
                        $sheet->setCellValue('T' . $row, $delivery->delivered_by);
                        $sheet->setCellValue('U' . $row, $delivery->agents);
                        $sheet->setCellValue('V' . $row, $delivery->payment_remarks);
           
                        $sheet->getStyle('O' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                        $sheet->getStyle('P' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                        $sheet->getStyle('Q' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                        $sheet->getStyle('R' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                        $sheet->getStyle('S' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->getStyle('K' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->getStyle('L' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->getStyle('T' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->getStyle('U' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->getStyle('V' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $row++; // Move to the next set of rows for the next store
                    }
                }

            if(isset($request->report) && $request->report == "4") {
                // eloquent with raw query definition
                $deliveries = Deliveries::with(['deliverystatus', 'paymentstatus'])
                ->join('payments as p', function($join) {
                    $join->on('p.id', '=', 'deliveries.payment_id')
                            ->where('p.deleted', 0);
                })
                ->join('payment_statuses', 'payment_statuses.id', '=', 'deliveries.payment_status')
                ->where('deliveries.deleted', 0)
                ->select(
                    'p.updated_at as payment_date',
                    'deliveries.dr_no',
                    'payment_statuses.name as paymentstatus_name',
                    'p.payment_type as payment_type',
                    'p.payment_references as payment_reference',
                    'store_name',
                    'grandtotal_amount',
                    'payment_remarks'
                )
                ->where(function ($query) use ($request, $date_1, $date_2) {
                    if ($request->has('as_of') && $request->as_of !== null) {
                        $query->whereBetween('deliveries.delivered_date', [$date_1, $date_2]);
                    }
                })
                ->where('deliveries.deleted', 0)
                ->orderBy('deliveries.id')
                ->get();
                
                
                $templatePath = public_path('excel_templates/payment-details-report-template.xlsx');
                
                $spreadsheet = IOFactory::load($templatePath);
        
        
                // Create a new Spreadsheet instance
                $new_spreadsheet = new Spreadsheet();
                $sheet = $new_spreadsheet->getActiveSheet();
        
                // header
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A3', 'Date Printed: ' . Carbon::now()->format('m/d/Y h:i:s A'));
                $sheet->setCellValue('A4', 'Prepared By: ' . Auth::user()->name);
                $sheet->setCellValue('A5', $a4_title);
        
                // // body; Starts as A7
                $row = 8;
        
                    foreach ($deliveries as $ks => $delivery) {
                        $sheet->setCellValue('A' . $row, $delivery->payment_date);
                        $sheet->setCellValue('B' . $row, $delivery->dr_no);
                        $sheet->setCellValue('C' . $row, $delivery->paymentstatus_name);
                        $sheet->setCellValue('D' . $row, $delivery->payment_type);
                        $sheet->setCellValue('E' . $row, $delivery->payment_reference);
                        $sheet->setCellValue('F' . $row, $delivery->store_name);
                        $sheet->setCellValue('G' . $row, $delivery->grandtotal_amount);
                        $sheet->setCellValue('H' . $row, $delivery->payment_remarks);
            
                        $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0.00');

                        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $row++; // Move to the next set of rows for the next store
                    }
                }

        // Save the spreadsheet to a file
        $current_datetime = Carbon::now()->format('Y-m-d hia');
        $filename = 'Delivery Report - ' . $current_datetime . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path() . '/app/public/' . $filename);

        // Return a download response if needed and (IMPORTANT!) delete the temporary file
        return response()->download(storage_path() . '/app/public/' . $filename)->deleteFileAfterSend(true);
    }
}
