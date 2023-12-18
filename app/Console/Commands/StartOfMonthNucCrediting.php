<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Nuc;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class StartOfMonthNucCrediting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:startOfMonthNucCredit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'First day of the month crediting of NUC points';

    /**
     * Execute the console command.
     */
    public function handle()
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

        // from the 28th to month end
        $from = date('Y-m-28 00:00:00', strtotime('last month'));
        $to = date('Y-m-t 23:59:59', strtotime('last month'));

        // nucs
        $nucs = Nuc::whereBetween('created_at', [$from, $to])
                    ->whereStatus(0)
                    ->get();

                      // additional validation: this is also scheduled under cron jobs on the 1st day of the month
        if($nucs && date('d') == 1) {
            foreach($nucs as $nuc) {

                // remove comma from total nuc points
                $total_nuc = str_replace(',','',$nuc->total_nuc);
                
                // Regular Distributor
                // if($nuc->account_type_id == 1) {
                //     // api - [NewULCashPurchases]
                //     $res = Http::withHeaders(['Content-Type' => 'application/json','Authorization' => 'Bearer ' . $global_token['access_token'], 'Accept' => 'application/json'])
                //                 ->post(env('PRIME_API') . 'nuccredit/newulcashpurchases/' . $nuc->bcid . '/' . $total_nuc);
                                
                //     if($res->status() == 200) {
                //         // update nuc
                //         $nuc->status = 1;
                //         $nuc->updated_at = Carbon::now()->toDateTimeString();
                //         $nuc->update();
                //     }

                // UBC and UPC 
                // } else { 
                    $res = Http::withHeaders(['Content-Type' => 'application/json','Authorization' => 'Bearer ' . $global_token['access_token'], 'Accept' => 'application/json'])
                                ->post(env('PRIME_API') . 'nuccredit/newulcreditlimit/' . $nuc->bcid . '/' . $total_nuc . '/' . $nuc->branch . '/' . $nuc->oid);
    
                    if($res->status() == 200) {
                        // update nuc
                        $nuc->status = 1;
                        $nuc->updated_at = Carbon::now()->toDateTimeString();
                        $nuc->update();
                    }
                // }
                sleep(8);
            }
        }
        return 0;
    }
}
