<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaintainedMember;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
class MaintainedMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintained_members = MaintainedMember::orderByDesc('year')->orderByDesc('month')->get();
        return view('tools.maintained_member.index', compact('maintained_members'));
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

    public function sync()
    {
        //create global token to retrieve product details
        $global_token = Http::asForm()->post(env('PRIME_IDP'), [
            'username' => 'spectator',
            'password' => '6fYR72',
            'grant_type' => 'password',
            'client_secret' => 'TDOXe4BPfSv-OJ_Pbb4tshdQETl0EKJpkVPeoHKf6dg',
            'client_id' => 'prime-apps', 
            'Content-type' => 'application/x-www-form-urlencoded; charset=utf-8'
        ]);

        $last_id = 0;
        // get the last data id
        $last_data_id = MaintainedMember::orderBy('id','desc')->first();
        if($last_data_id) {
            $last_id = $last_data_id->data_id;
        }
        
        $res = Http::withHeaders(['Content-Type' => 'application/json','Authorization' => 'Bearer ' . $global_token['access_token'], 'Accept' => 'application/json'])
                                ->get(env('PRIME_API') . 'maintained-members/' . $last_id);
 
        if($res->status() == 200) {
            // append the maintained members
            $data = json_decode($res->getBody()->getContents(), true);

            foreach($data as $key => $member) {
                $new = new MaintainedMember();
                $new->uuid = Str::uuid();
                $new->data_id = $member['ID']; // case sensitive
                $new->bcid = $member['BCID']; // case sensitive
                $new->year = $member['Year']; // case sensitive
                $new->month = $member['Month']; // case sensitive
                $new->save();
            }
             
            return true;
        } else {
            return false;
        }
        
    }
}
