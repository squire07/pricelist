<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Nuc;
use Carbon\Carbon;
use App\Helpers\Helper;
use Auth;

class NucReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // default to today's date
        $from = Carbon::now()->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::now()->format('Y-m-d') . ' 23:59:59';

        if($request->has('daterange')) {
            $date = explode(' - ',$request->daterange);
            $from = date('Y-m-d', strtotime($date[0])) . ' 00:00:00';                                                                                                                                                      
            $to = date('Y-m-d', strtotime($date[1])) . ' 23:59:59';
        } 

        $nucs = Nuc::with('sales')
                    ->whereDeleted(false)
                    ->whereBetween('created_at', [$from, $to])
                    ->where(function ($query) use ($request) {
                        if ($request->has('branch_id') && $request->branch_id != '') {
                            $query->whereIn('branch', [Helper::get_branch_name_by_id($request->branch_id)]);
                        } else {
                            $query->when(!in_array(Auth::user()->role_id, [11, 12]), function($query) {
                                $branch_ids = explode(',', Auth::user()->branch_id);
                                $branch_names = explode(',', Helper::get_branch_name_by_id(Auth::user()->branch_id));
                                $query->whereIn('branch', $branch_names);
                            });
                        }
                    })  
                    ->get();

        // users branch
        $branches = Branch::whereStatusId(8)
                        ->when(!in_array(Auth::user()->role_id, [11, 12]), function($query) {
                            $branch_ids = explode(',', Auth::user()->branch_id);
                            $query->whereIn('id', $branch_ids);
                        })
                        ->orderBy('name')->get();
        
        return view('report.nuc.index', compact('nucs','branches'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
