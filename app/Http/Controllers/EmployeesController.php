<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Role;
use App\Models\Cities;
use App\Helpers\Helper;
use App\Models\Company;
use App\Models\Barangay;
use App\Models\Province;
use App\Models\Employees;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\AgentCategories;
use App\Models\EmployeeDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employees::whereDeleted(false)->get();
        
        $companies = Company::whereDeleted(false)->get();

        $departments = Department::whereDeleted(false)->get();

        $roles = Role::whereDeleted(false)->get();

        $agent_categories = AgentCategories::whereDeleted(false)->get();

        return view('employee.index',compact('employees','companies','departments','agent_categories','roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employees::whereDeleted(false)->get();
        
        $companies = Company::whereDeleted(false)->get();

        $departments = Department::whereDeleted(false)->get();

        $roles = Role::whereDeleted(false)->get();

        $agent_categories = AgentCategories::whereDeleted(false)->get();

        $provinces = Province::whereDeleted(false)->get();

        $cities = Cities::whereDeleted(false)->get();

        $barangays = Barangay::whereDeleted(false)->get();

        return view('employee.create',compact('employees','companies','departments','agent_categories','roles','provinces','cities','barangays'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
        $exist = Employees::whereCode($request->code)->whereDeleted(false)->first();
        if(!$exist) {
            $employee = new Employees();
            $employee->uuid = Str::uuid();
            $employee->code = Helper::generateNextEmployeeCode();
            $employee->first_name = $request->first_name;
            $employee->middle_name = $request->middle_name;
            $employee->last_name = $request->last_name;
            $employee->full_name = $request->full_name;
            $employee->gender = $request->gender;
            $employee->civil_status = $request->civil_status;
            $employee->birthdate = $request->birthdate;
            $employee->age = $request->age;
            $employee->height = $request->height;
            $employee->weight = $request->weight;
            $employee->religion = $request->religion;
            $employee->nationality = $request->nationality;
            $employee->company_id = 1;
            $employee->department_id = $request->department_id;
            $employee->role_id = $request->role_id;
            $employee->agent_category = $request->agent_category;
            $employee->tin = $request->tin;
            $employee->phic = $request->philhealth;
            $employee->sss = $request->sss;
            $employee->hdmf = $request->pagibig;
            $employee->national_id = $request->national_id;
            $employee->umid = $request->umid;
            $employee->passport = $request->passport;
            $employee->drivers_license = $request->drivers_license;
            $employee->house_number = $request->house_number;
            $employee->zip_code = $request->zip_code;
            $employee->street = $request->street;
            $employee->barangay = $request->barangay;
            $employee->city = $request->city;
            $employee->province = $request->province;
            $employee->contact_details = $request->contact_number;
            $employee->emergency_contact_name = $request->emergency_contact_name;
            $employee->emergency_contact_number = $request->emergency_contact_number;
            $employee->employee_type = $request->employee_type;
            $employee->date_hired = $request->date_hired;
            $employee->date_separated = $request->date_separated;
            $employee->pay_frequency = $request->pay_frequency;
            $employee->basic_pay = $request->basic_pay;
            $employee->rate_per_day = $request->rate_per_day;
            $employee->rate_per_hour = $request->rate_per_hour;
            $employee->ot_rate_per_hour = $request->ot_rate_per_hour;
            $employee->remarks = $request->remarks;
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                $imageName = Str::random(10) . '.' . $images->getClientOriginalExtension();
            
                // Specify the public path where the image will be stored
                $publicPath = public_path('images/employees'); // Adjust the directory as needed
            
                // Store the image in the specified path
                $images->move($publicPath, $imageName);
            
                $employee->images = 'images/employees/' . $imageName;
            }
            $employee->active = 1;
            $employee->created_by = Auth::user()->name;
            $employee->save();
        }
        return redirect('employees')->with('success', $employee->full_name . ' Successfully saved!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employees $employees, $uuid)
    {
        $employee = Employees::with('agentcategory','provinces','cities','barangays')->whereUuid($uuid)
                            ->firstOrFail();

        //$histories = History::whereUuid($delivery->uuid)->whereDeleted(false)->get();
        
        return view('employee.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employees $employees, $uuid)
    {
        $employees = Employees::with('department','role','agentcategory','provinces','cities','barangays')                   
                            ->whereUuid($uuid)
                            ->firstOrFail();

        //$histories = History::whereUuid($delivery->uuid)->whereDeleted(false)->get();
        
        $companies = Company::whereDeleted(false)->get();

        $departments = Department::whereDeleted(false)->get();

        $roles = Role::whereDeleted(false)->get();

        $agent_categories = AgentCategories::whereDeleted(false)->get();
        
        $provinces = Province::whereDeleted(false)->get();

        $cities = Cities::whereDeleted(false)->get();

        $barangays = Barangay::whereDeleted(false)->get();

        return view('employee.edit',compact('employees','companies','departments','agent_categories','roles','provinces','cities','barangays'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {

        //dd($request);
        //$employee = Employees::findOrFail($uuid);
    
        // Check if the new name is unique, excluding the current product
        $employee = Employees::whereUuid($uuid)->whereDeleted(false)->firstOrFail();
        if (Employees::where('code', $request->code)->whereNot('uuid', $uuid)->exists()) {
            return redirect()->back()->with('error', "Employee code already exists!");
        } 

        $employee->first_name = $request->first_name ?? $employee->first_name;
        $employee->middle_name = $request->middle_name ?? $employee->middle_name;
        $employee->last_name = $request->last_name ?? $employee->last_name;
        $employee->full_name = $request->full_name ?? $employee->full_name;
        $employee->gender = $request->gender ?? $employee->gender;
        $employee->civil_status = $request->civil_status ?? $employee->civil_status;
        $employee->birthdate = $request->birthdate ?? $employee->birthdate;
        $employee->age = $request->age ?? $employee->age;
        $employee->height = $request->height ?? $employee->height;
        $employee->weight = $request->weight ?? $employee->weight;
        $employee->religion = $request->religion ?? $employee->religion;
        $employee->nationality = $request->nationality ?? $employee->nationality;
        $employee->department_id = $request->department_id ?? $employee->department_id;
        $employee->role_id = $request->role_id ?? $employee->role_id;
        $employee->agent_category = $request->agent_category ?? $employee->agent_category;
        $employee->tin = $request->tin ?? $employee->tin;
        $employee->phic = $request->philhealth ?? $employee->phic;
        $employee->sss = $request->sss ?? $employee->sss;
        $employee->hdmf = $request->pagibig ?? $employee->hdmf;
        $employee->national_id = $request->national_id ?? $employee->national_id;
        $employee->umid = $request->umid ?? $employee->umid;
        $employee->passport = $request->passport ?? $employee->passport;
        $employee->drivers_license = $request->drivers_license ?? $employee->drivers_license;
        $employee->house_number = $request->house_number ?? $employee->house_number;
        $employee->zip_code = $request->zip_code ?? $employee->zip_code;
        $employee->street = $request->street ?? $employee->street;
        $employee->barangay = $request->barangay ?? $employee->barangay;
        $employee->city = $request->city ?? $employee->city;
        $employee->province = $request->province ?? $employee->province;
        $employee->contact_details = $request->contact_number ?? $employee->contact_details;
        $employee->emergency_contact_name = $request->emergency_contact_name ?? $employee->emergency_contact_name;
        $employee->emergency_contact_number = $request->emergency_contact_number ?? $employee->emergency_contact_number;
        $employee->employee_type = $request->employee_type ?? $employee->employee_type;
        $employee->date_hired = $request->date_hired ?? $employee->date_hired;
        $employee->date_separated = $request->date_separated ?? $employee->date_separated;
        $employee->pay_frequency = $request->pay_frequency ?? $employee->pay_frequency;
        $employee->basic_pay = str_replace(',', '', $request->basic_pay) ?? $employee->basic_pay;
        $employee->rate_per_day = str_replace(',', '', $request->rate_per_day) ?? $employee->rate_per_day;
        $employee->rate_per_hour = str_replace(',', '', $request->rate_per_hour) ?? $employee->rate_per_hour;
        $employee->ot_rate_per_hour = str_replace(',', '', $request->ot_rate_per_hour) ?? $employee->ot_rate_per_hour;
        $employee->remarks = $request->remarks ?? $employee->remarks;
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $imageName = Str::random(10) . '.' . $images->getClientOriginalExtension();
        
            // Specify the public path where the image will be stored
            $publicPath = public_path('images/employees'); // Adjust the directory as needed
        
            // Store the image in the specified path
            $images->move($publicPath, $imageName);
        
            $employee->images = 'images/employees/' . $imageName;
            }
            $employee->active = $request->active ?? $employee->active;
            $employee->created_by = Auth::user()->name;
            $employee->update();

        return redirect('employees')->with('success', $employee->full_name . ' Successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employees $employees)
    {
        //
    }

    public function getCities($province)
    {
        $cities = Cities::where('province_id', $province)->get();
        return response()->json($cities);
    }

    public function getBarangays($city)
    {
        $barangays = Barangay::where('city_id', $city)->get();
        return response()->json($barangays);
    }
}
