<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    public function company()
    {
        return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }

    public function role()
    {
        return $this->hasOne('App\Models\Role', 'id', 'role_id');
    }

    public function department()
    {
        return $this->hasOne('App\Models\Department', 'id', 'department_id');
    }

    public function agentcategory()
    {
        return $this->hasOne('App\Models\AgentCategories', 'id', 'agent_category');
    }

    public function employee_details()
    {
        return $this->hasMany('App\Models\EmployeeDetails', 'employee_id', 'id');
    }
    
    public function provinces()
    {
        return $this->hasOne('App\Models\Province', 'id', 'province');
    }

    public function cities()
    {
        return $this->hasOne('App\Models\Cities', 'id', 'city');
    }

    public function barangays()
    {
        return $this->hasOne('App\Models\Barangay', 'id', 'barangay');
    }
}
