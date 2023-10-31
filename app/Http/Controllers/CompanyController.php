<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Company;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Auth;
use Illuminate\Support\Facades\Artisan;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::with('status')->whereDeleted(false)->get();
        return view('company.index',compact('companies'));
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
        $exist = Company::whereName($request->name)->whereCode($request->code)->whereDeleted(false)->first();
        if(!$exist) {
            $company = new Company();
            $company->uuid = Str::uuid();
            $company->name = $request->name;
            $company->code = $request->code;
            $company->created_by = Auth::user()->name;
            $company->save();
            return redirect()->back()->with('success', 'Company has been created!');
        } else {
            return redirect()->back()->with('error', 'Company already exists!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $company = Company::whereUuid($uuid)->whereDeleted(false)->firstOrFail();
        $company->name = $request->name;
        $company->code = $request->code;
        $company->status_id = $request->status;
        $company->remarks = $request->remarks;
        $company->updated_by = Auth::user()->name;
        $company->update();

        return redirect('companies')->with('success', 'Company has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $company = Company::whereUuid($uuid)->whereDeleted(false)->firstOrFail();
        $company->deleted = 1; // boolean 1 = true
        $company->deleted_at = Carbon::now();
        $company->deleted_by = Auth::user()->name;
        $company->update();

        return redirect('companies')->with('success', $company->name . ' has been deleted!');
    }

    // this should be moved at api
    public function sync_company()
    {
        // to refactor soon
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('companies')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Artisan::call('db:seed', ['--class' => 'CompanySeeder',]);
        return true;
    }
}
