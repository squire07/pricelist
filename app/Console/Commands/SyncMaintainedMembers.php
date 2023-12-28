<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MaintainedMember;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class SyncMaintainedMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SyncMaintainedMembers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the latest records of maintained members daily';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // create global token to retrieve product details
        $global_token = Http::asForm()->post(env('PRIME_IDP'), [
            'username' => 'spectator',
            'password' => '6fYR72',
            'grant_type' => 'password',
            'client_secret' => 'TDOXe4BPfSv-OJ_Pbb4tshdQETl0EKJpkVPeoHKf6dg',
            'client_id' => 'prime-apps', 
            'Content-type' => 'application/x-www-form-urlencoded; charset=utf-8'
        ]);

        // get the last data id
        $last_data_id = MaintainedMember::orderBy('id','desc')->first();
        
        $res = Http::withHeaders(['Content-Type' => 'application/json','Authorization' => 'Bearer ' . $global_token['access_token'], 'Accept' => 'application/json'])
                                ->get(env('PRIME_API') . 'maintained-members/' . $last_data_id);
 
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
