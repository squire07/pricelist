<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\PaymentList;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $payment_lists = [
        //     1 => array('name' => 'GCashUNOEcomm', 'code' => '003'),
        //     2 => array('name' => 'BDO', 'code' => '3920049009'),
        //     3 => array('name' => 'EastwestBank', 'code' => '200007016076'),
        //     4 => array('name' => 'GCashUNOBaguio', 'code' => '008'),
        //     5 => array('name' => 'GCashUNOCalamba', 'code' => '007'),
        //     6 => array('name' => 'GCashUNOCebu', 'code' => '004'),
        //     7 => array('name' => 'GCashUNOLocalInsula', 'code' => '001'),
        //     8 => array('name' => 'GCashUNOGensan', 'code' => '006'),
        //     9 => array('name' => 'RCBC', 'code' => '1150006089'),
        //     10 => array('name' => 'Security Bank', 'code' => '3920049009'),
        //     11 => array('name' => 'Union Bank', 'code' => '200007016076'),
        //     12 => array('name' => 'Union Bank', 'code' => '008'),
        //     13 => array('name' => 'Union Bank of the Philippines', 'code' => '007'),
        //     14 => array('name' => 'BDO', 'code' => '004'),
        //     15 => array('name' => 'Union Bank', 'code' => '100590246608'),
        //     16 => array('name' => 'GCashUNOGensan', 'code' => '006'),
        // ];



        /*
        * IMPORTANT! Branch id with numerical value specifies specific branch.
        * Branch id LO specifies local branches aside from West Insula Local.
        * Branch id PR specifies premier branches aside from West Insula Premier.
        */

        $payment_lists = [
            // west local
            1 => array('name' => 'CASH-UNDEPOSITED COLLECTIONS', 'code' => '1000002', 'branch_id' => '1'),
            2 => array('name' => 'LO HEAD OFFICE SUPLIER EW PHP CA 6076', 'code' => '1000018', 'branch_id' => '1'),
            3 => array('name' => 'LO HEAD UBS BDO PHP SA 9009', 'code' => '1000035', 'branch_id' => '1'),
            4 => array('name' => 'BDO S/A 710 CREDIT CARD', 'code' => '1000043', 'branch_id' => '1'),
            5 => array('name' => 'RCBC S/A 089 COMM', 'code' => '1000046', 'branch_id' => '1'),
            6 => array('name' => 'UB S/A - 8107 VITO CRUZ', 'code' => '1000051', 'branch_id' => '1'),
            7 => array('name' => 'UB C/A HEAD 26-288', 'code' => '1000054', 'branch_id' => '1'),
            8 => array('name' => 'SB C/A733', 'code' => '1000058', 'branch_id' => '1'),
            9 => array('name' => 'UB BGC UNO PREMIER 608', 'code' => '1000064', 'branch_id' => '1'),
            10 => array('name' => 'A/R GCASH', 'code' => '1000130', 'branch_id' => '1'),
            11 => array('name' => 'ACCOUNTS RECEIVABLE-TRADE', 'code' => '1010001', 'branch_id' => '1'),
            12 => array('name' => 'ACCOUNT RECEIVABLE - PDC', 'code' => '1010008', 'branch_id' => '1'),
            13 => array('name' => 'CONTRA COMMISSION', 'code' => '6000064', 'branch_id' => '1'),
            14 => array('name' => 'E STORE COMMISSION', 'code' => '6000072', 'branch_id' => '1'),

            // west premier


            // ecomm local
            15 => array('name' => 'CASH-UNDEPOSITED COLLECTIONS', 'code' => '1000002', 'branch_id' => '6'),
            16 => array('name' => 'LO HEAD OFFICE SUPLIER EW PHP CA 6076', 'code' => '1000018', 'branch_id' => '6'),
            17 => array('name' => 'LO HEAD UBS BDO PHP SA 9009', 'code' => '1000035', 'branch_id' => '6'),
            18 => array('name' => 'RCBC S/A 089 COMM', 'code' => '1000046', 'branch_id' => '6'),
            19 => array('name' => 'BPI S/A 761', 'code' => '1000050', 'branch_id' => '6'),
            20 => array('name' => 'UB S/A - 8107 VITO CRUZ', 'code' => '1000051', 'branch_id' => '6'),
            21 => array('name' => 'UB C/A HEAD 26-288', 'code' => '1000054', 'branch_id' => '6'),
            22 => array('name' => 'SB C/A733', 'code' => '1000058', 'branch_id' => '6'),
            23 => array('name' => 'UB BGC UNO PREMIER 608', 'code' => '1000064', 'branch_id' => '6'),
            24 => array('name' => 'A/R GCASH', 'code' => '1000130', 'branch_id' => '6'),
            25 => array('name' => 'A/R UNOSHOPPH (P/L)', 'code' => '1000125', 'branch_id' => '6'),
            26 => array('name' => 'ADVERTISING & PROMOTION EXPENSE', 'code' => '6000073', 'branch_id' => '6'),

            // ecomm premier
            27 => array('name' => 'CASH-UNDEPOSITED COLLECTIONS', 'code' => '1000002', 'branch_id' => '12'),
            28 => array('name' => 'LO HEAD OFFICE SUPLIER EW PHP CA 6076', 'code' => '1000018', 'branch_id' => '12'),
            29 => array('name' => 'LO HEAD UBS BDO PHP SA 9009', 'code' => '1000035', 'branch_id' => '12'),
            30 => array('name' => 'PR BGC BDO PHP SA 074', 'code' => '1000036', 'branch_id' => '12'),
            31 => array('name' => 'BPI S/A 761', 'code' => '1000050', 'branch_id' => '12'),
            32 => array('name' => 'UB BGC UNO PREMIER 608', 'code' => '1000064', 'branch_id' => '12'),
            33 => array('name' => 'BDO UNO PREMIER NEW 074', 'code' => '1000069', 'branch_id' => '12'),
            34 => array('name' => 'A/R UNOSHOPP (P/L)', 'code' => '1000125', 'branch_id' => '12'),
            35 => array('name' => 'PAY PALL', 'code' => '1000126', 'branch_id' => '12'),
            36 => array('name' => 'A/R LAZAMALL', 'code' => '1000129', 'branch_id' => '12'),
            37 => array('name' => 'ADVERTISING & PROMOTION EXPENSE', 'code' => '6000073', 'branch_id' => '12'),

            // other local branches
            38 => array('name' => 'CASH-UNDEPOSITED COLLECTIONS', 'code' => '1000002', 'branch_id' => 'LO'),
            39 => array('name' => 'LO HEAD OFFICE SUPLIER EW PHP CA 6076', 'code' => '1000018', 'branch_id' => 'LO'),
            40 => array('name' => 'LO HEAD UBS BDO PHP SA 9009', 'code' => '1000035', 'branch_id' => 'LO'),
            41 => array('name' => 'BDO S/A 710 CREDIT CARD', 'code' => '1000043', 'branch_id' => 'LO'),
            42 => array('name' => 'RCBC S/A 089 COMM', 'code' => '1000046', 'branch_id' => 'LO'),
            43 => array('name' => 'MBTC S/A 366', 'code' => '1000049', 'branch_id' => 'LO'),
            44 => array('name' => 'UB S/A - 8107 VITO CRUZ', 'code' => '1000051', 'branch_id' => 'LO'),
            45 => array('name' => 'UB C/A HEAD 26-288', 'code' => '1000054', 'branch_id' => 'LO'),
            46 => array('name' => 'SB C/A733', 'code' => '1000058', 'branch_id' => 'LO'),
            47 => array('name' => 'A/R GCASH', 'code' => '1000130', 'branch_id' => 'LO'),
            48 => array('name' => 'CONTRA COMMISSION', 'code' => '6000064', 'branch_id' => 'LO'),
            49 => array('name' => 'E STORE COMMISSION', 'code' => '6000072', 'branch_id' => 'LO'),

            // other premier branches
            50 => array('name' => 'CASH-UNDEPOSITED COLLECTIONS', 'code' => '1000002', 'branch_id' => 'PR'),
            51 => array('name' => 'PR BGC BDO PHP SA 074', 'code' => '1000036', 'branch_id' => 'PR'),
            52 => array('name' => 'BDO S/A 710 CREDIT CARD', 'code' => '1000043', 'branch_id' => 'PR'),
            53 => array('name' => 'MBTC S/A 366', 'code' => '1000049', 'branch_id' => 'PR'),
            54 => array('name' => 'UB BGC UNO PREMIER 608', 'code' => '1000064', 'branch_id' => 'PR'),
            55 => array('name' => 'BDO UNO PREMIER NEW 074', 'code' => '1000069', 'branch_id' => 'PR'),
            56 => array('name' => 'BDO NW ACCOUNT 5084', 'code' => '1000039', 'branch_id' => 'PR'),
        ];

        foreach($payment_lists as $key => $payment_list) {
            PaymentList::create([
                'uuid' => Str::uuid(),
                'name' => $payment_list['name'],
                'code' => $payment_list['code'],
                'branch_id' => $payment_list['branch_id'],
                'company_id' => 1,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
