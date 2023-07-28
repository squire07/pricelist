<?php

namespace App\Http\Controllers;

use App\Models\TestBuildReport;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TestBuildReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('testbuildreport.index');
    }

    public function generate(request $request)
    {
        $startDate = Carbon::parse($request['start_date'])->startOfDay();
        $endDate = Carbon::parse($request['end_date'])->endOfDay();
  
        $testbuildreports = TestBuildReport::whereBetween('date', [$startDate, $endDate])->get();
        return view('testbuildreport.generate', compact('testbuildreports'));
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
    public function show(TestBuildReport $testBuildReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TestBuildReport $testBuildReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TestBuildReport $testBuildReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TestBuildReport $testBuildReport)
    {
        //
    }
}
