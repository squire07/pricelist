<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentCategories extends Model
{
    use HasFactory;
    
    public function agentcategories()
    {
        return $this->belongsTo('App\Models\Employees', 'agent_category', 'id');
    }
}
