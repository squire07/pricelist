<?php

namespace App\Http\Controllers;

use Cache;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Http;

class DistributorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->key = 'TDOXe4BPfSv-OJ_Pbb4tshdQETl0EKJpkVPeoHKf6dg';
        $this->prime_idp = env('PRIME_IDP');
        $this->prime_api = env('PRIME_API');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $global_token = Http::asForm()->post($this->prime_idp, [
            'username' => 'spectator',
            'password' => '6fYR72',
            'grant_type' => 'password',
            'client_secret' => $this->key,
            'client_id' => 'prime-apps', 
            'Content-type' => 'application/x-www-form-urlencoded; charset=utf-8'
        ]);
        
        if ($global_token->getStatusCode() == 200) {
            $global_token = 'Bearer ' . $global_token['access_token'];
      

            // get the last bcid from the distributors table
            $last_bcid = Distributor::latest()->first();

            $new_members = Http::withHeaders(['Content-Type' => 'application/json','Authorization' => $global_token,'Accept' => 'application/json'])
                                        ->get($this->prime_api . 'getNewMembers/' . '003205506090'); // TEMPORARY ONLY FOR TESTING -- $last_bcid->bcid;

            // dd($new_members->getStatusCode());
            if($new_members->getStatusCode() == 200) {
                $stream = $new_members->getBody();
                $contents = $stream->getContents();
                $contents = json_decode($contents, true);

                foreach($contents as $dist) {
                    $distributor = new Distributor();
                    $distributor->bcid = $dist['BCID'];
                    $distributor->name = $dist['FirstName'] . ' ' . $dist['MiddleName'] . ' ' . $dist['LastName'];
                    $distributor->group = $dist['MotherGroup'];
                    $distributor->subgroup = $dist['SubGroup'];
                    // $distributor->save();
                }
            }

        }
        return view('distributor.index');
    }

    /**
     * Returns json object. DataTable with handle the get() property.
     */
    public function distributor_list() 
    {
        $distributors = Distributor::whereDeleted(false);
        return DataTables::of($distributors)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // will be done at Prime Dashboard
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // will be done at Prime Dashboard
    }


    /**
     * Display the specified resource.
     */
    public function show(Distributor $distributor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Distributor $distributor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Distributor $distributor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Distributor $distributor)
    {
        //
    }

    public function sync_distributors()
    {
        $global_token = Http::asForm()->post($this->prime_idp, [
            'username' => 'spectator',
            'password' => '6fYR72',
            'grant_type' => 'password',
            'client_secret' => $this->key,
            'client_id' => 'prime-apps', 
            'Content-type' => 'application/x-www-form-urlencoded; charset=utf-8'
        ]);
        
        if ($global_token->getStatusCode() == 200) {
            $global_token = 'Bearer ' . $global_token['access_token'];
        
            // get the last bcid from the distributors table
            $last_bcid = Distributor::latest()->first();

            $new_members = Http::withHeaders(['Content-Type' => 'application/json','Authorization' => $global_token,'Accept' => 'application/json'])
                                        ->get($this->prime_api . 'getNewMembers/' . $last_bcid->bcid);

            // dd($new_members->getStatusCode());
            if($new_members->getStatusCode() == 200) {
                $stream = $new_members->getBody();
                $contents = $stream->getContents();
                $contents = json_decode($contents, true);

                foreach($contents as $dist) {
                    $distributor = new Distributor();
                    $distributor->bcid = $dist['BCID'];
                    $distributor->name = $dist['FirstName'] . ' ' . $dist['MiddleName'] . ' ' . $dist['LastName'];
                    $distributor->group = $dist['MotherGroup'];
                    $distributor->subgroup = $dist['SubGroup'];
                    $distributor->save();
                }
            }
            return true;
        } else {
            return false;
        }
    }
}
