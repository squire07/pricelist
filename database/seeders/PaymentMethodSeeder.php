<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\PaymentMethod;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        * IMPORTANT! Branch id with numerical value specifies specific branch.
        * Branch id LO specifies local branches aside from West Insula Local.
        * Branch id PR specifies premier branches aside from West Insula Premier.
        */

        // $payment_lists = [
        //     // west local
        //     1 => array('name' => 'CASH-UNDEPOSITED COLLECTIONS', 'code' => '1000002', 'branch_id' => '1', 'is_cash' => '1'),
        //     2 => array('name' => 'LO HEAD OFFICE SUPLIER EW PHP CA 6076', 'code' => '1000018', 'branch_id' => '1', 'is_cash' => '0'),
        //     3 => array('name' => 'LO HEAD UBS BDO PHP SA 9009', 'code' => '1000035', 'branch_id' => '1', 'is_cash' => '0'),
        //     4 => array('name' => 'BDO S/A 710 CREDIT CARD', 'code' => '1000043', 'branch_id' => '1', 'is_cash' => '0'),
        //     5 => array('name' => 'RCBC S/A 089 COMM', 'code' => '1000046', 'branch_id' => '1', 'is_cash' => '0'),
        //     6 => array('name' => 'UB S/A - 8107 VITO CRUZ', 'code' => '1000051', 'branch_id' => '1', 'is_cash' => '0'),
        //     7 => array('name' => 'UB C/A HEAD 26-288', 'code' => '1000054', 'branch_id' => '1', 'is_cash' => '0'),
        //     8 => array('name' => 'SB C/A733', 'code' => '1000058', 'branch_id' => '1', 'is_cash' => '0'),
        //     9 => array('name' => 'UB BGC UNO PREMIER 608', 'code' => '1000064', 'branch_id' => '1', 'is_cash' => '0'),
        //     10 => array('name' => 'A/R GCASH', 'code' => '1000130', 'branch_id' => '1', 'is_cash' => '0'),
        //     11 => array('name' => 'ACCOUNTS RECEIVABLE-TRADE', 'code' => '1010001', 'branch_id' => '1', 'is_cash' => '0'),
        //     12 => array('name' => 'ACCOUNT RECEIVABLE - PDC', 'code' => '1010008', 'branch_id' => '1', 'is_cash' => '0'),
        //     13 => array('name' => 'CONTRA COMMISSION', 'code' => '6000064', 'branch_id' => '1', 'is_cash' => '0'),
        //     14 => array('name' => 'E STORE COMMISSION', 'code' => '6000072', 'branch_id' => '1', 'is_cash' => '0'),

        //     // west premier


        //     // ecomm local
        //     // 15 => array('name' => 'CASH-UNDEPOSITED COLLECTIONS', 'code' => '1000002', 'branch_id' => '6', 'is_cash' => '1'),
        //     // 16 => array('name' => 'LO HEAD OFFICE SUPLIER EW PHP CA 6076', 'code' => '1000018', 'branch_id' => '6', 'is_cash' => '0'),
        //     // 17 => array('name' => 'LO HEAD UBS BDO PHP SA 9009', 'code' => '1000035', 'branch_id' => '6', 'is_cash' => '0'),
        //     // 18 => array('name' => 'RCBC S/A 089 COMM', 'code' => '1000046', 'branch_id' => '6', 'is_cash' => '0'),
        //     19 => array('name' => 'BPI S/A 761', 'code' => '1000050', 'branch_id' => '6', 'is_cash' => '0'),
        //     // 20 => array('name' => 'UB S/A - 8107 VITO CRUZ', 'code' => '1000051', 'branch_id' => '6', 'is_cash' => '0'),
        //     // 21 => array('name' => 'UB C/A HEAD 26-288', 'code' => '1000054', 'branch_id' => '6', 'is_cash' => '0'),
        //     // 22 => array('name' => 'SB C/A733', 'code' => '1000058', 'branch_id' => '6', 'is_cash' => '0'),
        //     // 23 => array('name' => 'UB BGC UNO PREMIER 608', 'code' => '1000064', 'branch_id' => '6', 'is_cash' => '0'),
        //     // 24 => array('name' => 'A/R GCASH', 'code' => '1000130', 'branch_id' => '6', 'is_cash' => '0'),
        //     25 => array('name' => 'A/R UNOSHOPPH (P/L)', 'code' => '1000125', 'branch_id' => '6', 'is_cash' => '0'),
        //     26 => array('name' => 'ADVERTISING & PROMOTION EXPENSE', 'code' => '6000073', 'branch_id' => '6', 'is_cash' => '0'),

        //     // ecomm premier
        //     // 27 => array('name' => 'CASH-UNDEPOSITED COLLECTIONS', 'code' => '1000002', 'branch_id' => '12', 'is_cash' => '1'),
        //     // 28 => array('name' => 'LO HEAD OFFICE SUPLIER EW PHP CA 6076', 'code' => '1000018', 'branch_id' => '12', 'is_cash' => '0'),
        //     // 29 => array('name' => 'LO HEAD UBS BDO PHP SA 9009', 'code' => '1000035', 'branch_id' => '12', 'is_cash' => '0'),
        //     30 => array('name' => 'PR BGC BDO PHP SA 074', 'code' => '1000036', 'branch_id' => '12', 'is_cash' => '0'),
        //     // 31 => array('name' => 'BPI S/A 761', 'code' => '1000050', 'branch_id' => '12', 'is_cash' => '0'),
        //     // 32 => array('name' => 'UB BGC UNO PREMIER 608', 'code' => '1000064', 'branch_id' => '12', 'is_cash' => '0'),
        //     33 => array('name' => 'BDO UNO PREMIER NEW 074', 'code' => '1000069', 'branch_id' => '12', 'is_cash' => '0'),
        //     // 34 => array('name' => 'A/R UNOSHOPP (P/L)', 'code' => '1000125', 'branch_id' => '12', 'is_cash' => '0'),
        //     35 => array('name' => 'PAY PALL', 'code' => '1000126', 'branch_id' => '12', 'is_cash' => '0'),
        //     36 => array('name' => 'A/R LAZAMALL', 'code' => '1000129', 'branch_id' => '12', 'is_cash' => '0'),
        //     // 37 => array('name' => 'ADVERTISING & PROMOTION EXPENSE', 'code' => '6000073', 'branch_id' => '12', 'is_cash' => '0'),

        //     // other local branches
        //     // 38 => array('name' => 'CASH-UNDEPOSITED COLLECTIONS', 'code' => '1000002', 'branch_id' => 'LO', 'is_cash' => '1'),
        //     // 39 => array('name' => 'LO HEAD OFFICE SUPLIER EW PHP CA 6076', 'code' => '1000018', 'branch_id' => 'LO', 'is_cash' => '0'),
        //     // 40 => array('name' => 'LO HEAD UBS BDO PHP SA 9009', 'code' => '1000035', 'branch_id' => 'LO', 'is_cash' => '0'),
        //     // 41 => array('name' => 'BDO S/A 710 CREDIT CARD', 'code' => '1000043', 'branch_id' => 'LO', 'is_cash' => '0'),
        //     // 42 => array('name' => 'RCBC S/A 089 COMM', 'code' => '1000046', 'branch_id' => 'LO', 'is_cash' => '0'),
        //     43 => array('name' => 'MBTC S/A 366', 'code' => '1000049', 'branch_id' => 'LO', 'is_cash' => '0'),
        //     // 44 => array('name' => 'UB S/A - 8107 VITO CRUZ', 'code' => '1000051', 'branch_id' => 'LO', 'is_cash' => '0'),
        //     // 45 => array('name' => 'UB C/A HEAD 26-288', 'code' => '1000054', 'branch_id' => 'LO', 'is_cash' => '0'),
        //     // 46 => array('name' => 'SB C/A733', 'code' => '1000058', 'branch_id' => 'LO', 'is_cash' => '0'),
        //     // 47 => array('name' => 'A/R GCASH', 'code' => '1000130', 'branch_id' => 'LO', 'is_cash' => '0'),
        //     // 48 => array('name' => 'CONTRA COMMISSION', 'code' => '6000064', 'branch_id' => 'LO', 'is_cash' => '0'),
        //     // 49 => array('name' => 'E STORE COMMISSION', 'code' => '6000072', 'branch_id' => 'LO', 'is_cash' => '0'),

        //     // other premier branches
        //     // 50 => array('name' => 'CASH-UNDEPOSITED COLLECTIONS', 'code' => '1000002', 'branch_id' => 'PR', 'is_cash' => '1'),
        //     // 51 => array('name' => 'PR BGC BDO PHP SA 074', 'code' => '1000036', 'branch_id' => 'PR', 'is_cash' => '0'),
        //     // 52 => array('name' => 'BDO S/A 710 CREDIT CARD', 'code' => '1000043', 'branch_id' => 'PR', 'is_cash' => '0'),
        //     // 53 => array('name' => 'MBTC S/A 366', 'code' => '1000049', 'branch_id' => 'PR', 'is_cash' => '0'),
        //     // 54 => array('name' => 'UB BGC UNO PREMIER 608', 'code' => '1000064', 'branch_id' => 'PR', 'is_cash' => '0'),
        //     // 55 => array('name' => 'BDO UNO PREMIER NEW 074', 'code' => '1000069', 'branch_id' => 'PR', 'is_cash' => '0'),
        //     56 => array('name' => 'BDO NW ACCOUNT 5084', 'code' => '1000039', 'branch_id' => 'PR', 'is_cash' => '0'),
        // ];


        $payment_methods = [
            1 => array('name' => 'CASH-UNDEPOSITED COLLECTIONS', 'code' => '1000002', 'branch_id' => '1,2,3,4,5,6,8,9,10,11,12', 'is_cash' => '1'),
            2 => array('name' => 'LO HEAD OFFICE SUPLIER EW PHP CA 6076', 'code' => '1000018', 'branch_id' => '1,2,3,4,5,6,8,9,10,11', 'is_cash' => '0'),
            3 => array('name' => 'LO HEAD UBS BDO PHP SA 9009', 'code' => '1000035', 'branch_id' => '1,2,3,4,5,6,8,9,10,11', 'is_cash' => '0'),
            4 => array('name' => 'BDO S/A 710 CREDIT CARD', 'code' => '1000043', 'branch_id' => '1,2,3,4,5,8,9,10,11', 'is_cash' => '0'),
            5 => array('name' => 'RCBC S/A 089 COMM', 'code' => '1000046', 'branch_id' => '1,2,3,4,5,6,7', 'is_cash' => '0'),
            6 => array('name' => 'UB S/A - 8107 VITO CRUZ', 'code' => '1000051', 'branch_id' => '1,2,3,4,5,6,7', 'is_cash' => '0'),
            7 => array('name' => 'UB C/A HEAD 26-288', 'code' => '1000054', 'branch_id' => '1,2,3,4,5,6,7', 'is_cash' => '0'),
            8 => array('name' => 'SB C/A733', 'code' => '1000058', 'branch_id' => '1,2,3,4,5,6,7', 'is_cash' => '0'),
            9 => array('name' => 'UB BGC UNO PREMIER 608', 'code' => '1000064', 'branch_id' => '1,6,8,9,10,11,12', 'is_cash' => '0'),
            10 => array('name' => 'A/R GCASH', 'code' => '1000130', 'branch_id' => '1,2,3,4,5,8,9,10,11', 'is_cash' => '0'),
            11 => array('name' => 'ACCOUNTS RECEIVABLE-TRADE', 'code' => '1010001', 'branch_id' => '1', 'is_cash' => '0'),
            12 => array('name' => 'ACCOUNT RECEIVABLE - PDC', 'code' => '1010008', 'branch_id' => '1', 'is_cash' => '0'),
            13 => array('name' => 'CONTRA COMMISSION', 'code' => '6000064', 'branch_id' => '1,2,3,4,5', 'is_cash' => '0'),
            14 => array('name' => 'E STORE COMMISSION', 'code' => '6000072', 'branch_id' => '1,2,3,4,5', 'is_cash' => '0'),

            19 => array('name' => 'BPI S/A 761', 'code' => '1000050', 'branch_id' => '6,12', 'is_cash' => '0'),
            25 => array('name' => 'A/R UNOSHOPPH (P/L)', 'code' => '1000125', 'branch_id' => '6,12', 'is_cash' => '0'),
            26 => array('name' => 'ADVERTISING & PROMOTION EXPENSE', 'code' => '6000073', 'branch_id' => '6,12', 'is_cash' => '0'),
            30 => array('name' => 'PR BGC BDO PHP SA 074', 'code' => '1000036', 'branch_id' => '7,8,9,10,11,12', 'is_cash' => '0'),
            33 => array('name' => 'BDO UNO PREMIER NEW 074', 'code' => '1000069', 'branch_id' => '7,8,9,10,11,12', 'is_cash' => '0'),
            35 => array('name' => 'PAY PALL', 'code' => '1000126', 'branch_id' => '12', 'is_cash' => '0'),
            36 => array('name' => 'A/R LAZAMALL', 'code' => '1000129', 'branch_id' => '12', 'is_cash' => '0'),
            43 => array('name' => 'MBTC S/A 366', 'code' => '1000049', 'branch_id' => '2,3,4,5,7,8,9,10,11', 'is_cash' => '0'),
            56 => array('name' => 'BDO NW ACCOUNT 5084', 'code' => '1000039', 'branch_id' => '7,8,9,10,11', 'is_cash' => '0'),
        ];

        foreach($payment_methods as $key => $payment_method) {
            PaymentMethod::create([
                'uuid' => Str::uuid(),
                'name' => $payment_method['name'],
                'code' => $payment_method['code'],
                'branch_id' => $payment_method['branch_id'],
                'company_id' => 1,
                'is_cash' => $payment_method['is_cash'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
