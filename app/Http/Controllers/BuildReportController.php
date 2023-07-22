<?php

namespace App\Http\Controllers;

use App\Models\BuildReport;
use Illuminate\Http\Request;

class BuildReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Buildreport.index');
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
