<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Nuc;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Log;

class DailyNucCrediting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:dailyNucCredit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily crediting of NUC points';

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

        if(date('d') < 28) {

            // today only
            $from = date('Y-m-d 00:00:00');
            $to = date('Y-m-d 23:59:59');

            // nucs
            $nucs = Nuc::with('sales')->whereBetween('created_at', [$from, $to])
                        ->whereStatus(0)
                        ->get();

            foreach($nucs as $nuc) {

                // remove comma from total nuc points
                $total_nuc = str_replace(',','',$nuc->total_nuc);

                // UBC, UPC
                if(in_array($nuc->sales->transaction_type_id, Helper::get_upc_ubc_transaction_ids())) {
                    $res = Http::withHeaders(['Content-Type' => 'application/json','Authorization' => 'Bearer ' . $global_token['access_token'], 'Accept' => 'application/json'])
                                ->post(env('PRIME_API') . 'nuccredit/newulcreditlimit/' . $nuc->bcid . '/' . $total_nuc . '/' . $nuc->branch . '/' . $nuc->oid);

                    if($res->status() == 200) {
                        // update nuc
                        $nuc->status = 1;
                        $nuc->updated_at = Carbon::now()->toDateTimeString();
                        $nuc->update();
                    }

                // RS
                } else { 
                    // api - [NewULCashPurchases]
                    $res = Http::withHeaders(['Content-Type' => 'application/json','Authorization' => 'Bearer ' . $global_token['access_token'], 'Accept' => 'application/json'])
                                ->post(env('PRIME_API') . 'nuccredit/newulcashpurchases/' . $nuc->bcid . '/' . $total_nuc . '/' . $nuc->branch . '/' . $nuc->oid);

                    if($res->status() == 200) {
                        // update nuc
                        $nuc->status = 1;
                        $nuc->updated_at = Carbon::now()->toDateTimeString();
                        $nuc->update();
                    }
                }
                sleep(8);

            }
        }
        return 0;
    }
}
