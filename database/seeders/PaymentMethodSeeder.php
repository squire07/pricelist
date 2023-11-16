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

        // $payment_methods = [
        //     1 => array('name' => 'CASH', 'description' => 'CASH-UNDEPOSITED COLLECTIONS', 'code' => '1000002', 'branch_id' => '1,2,3,4,5,6,8,9,10,11,12', 'is_cash' => '1'),
        //     2 => array('name' => 'LO HEAD OFFICE SUPPLIER EW PHP CA 6076', 'description' => 'LO HEAD OFFICE SUPPLIER EW PHP CA 6076', 'code' => '1000018', 'branch_id' => '1,2,3,4,5,6,8,9,10,11', 'is_cash' => '0'),
        //     3 => array('name' => 'LO HEAD UBS BDO PHP SA 9009', 'description' => 'LO HEAD UBS BDO PHP SA 9009', 'code' => '1000035', 'branch_id' => '1,2,3,4,5,6,8,9,10,11', 'is_cash' => '0'),
        //     4 => array('name' => 'BDO S/A 710 CREDIT CARD', 'description' => 'BDO S/A 710 CREDIT CARD', 'code' => '1000043', 'branch_id' => '1,2,3,4,5,8,9,10,11', 'is_cash' => '0'),
        //     5 => array('name' => 'RCBC S/A 089 COMM', 'description' => 'RCBC S/A 089 COMM', 'code' => '1000046', 'branch_id' => '1,2,3,4,5,6,7', 'is_cash' => '0'),
        //     6 => array('name' => 'UB S/A - 8107 VITO CRUZ', 'description' => 'UB S/A - 8107 VITO CRUZ', 'code' => '1000051', 'branch_id' => '1,2,3,4,5,6,7', 'is_cash' => '0'),
        //     7 => array('name' => 'UB C/A HEAD 26-288', 'description' => 'UB C/A HEAD 26-288', 'code' => '1000054', 'branch_id' => '1,2,3,4,5,6,7', 'is_cash' => '0'),
        //     8 => array('name' => 'SB C/A733', 'description' => 'SB C/A733', 'code' => '1000058', 'branch_id' => '1,2,3,4,5,6,7', 'is_cash' => '0'),
        //     9 => array('name' => 'UB BGC UNO PREMIER 608', 'description' => 'UB BGC UNO PREMIER 608', 'code' => '1000064', 'branch_id' => '1,6,8,9,10,11,12', 'is_cash' => '0'),
        //     10 => array('name' => 'GCASH', 'description' => 'A/R GCASH', 'code' => '1000130', 'branch_id' => '1,2,3,4,5,8,9,10,11', 'is_cash' => '0'),
        //     11 => array('name' => 'ACCOUNTS RECEIVABLE-TRADE', 'description' => 'ACCOUNTS RECEIVABLE-TRADE', 'code' => '1010001', 'branch_id' => '1', 'is_cash' => '0'),
        //     12 => array('name' => 'ACCOUNT RECEIVABLE - PDC', 'description' => 'ACCOUNT RECEIVABLE - PDC', 'code' => '1010008', 'branch_id' => '1', 'is_cash' => '0'),
        //     13 => array('name' => 'CONTRA COMMISSION', 'description' => 'CONTRA COMMISSION', 'code' => '6000064', 'branch_id' => '1,2,3,4,5', 'is_cash' => '0'),
        //     14 => array('name' => 'E STORE COMMISSION', 'description' => 'E STORE COMMISSION', 'code' => '6000072', 'branch_id' => '1,2,3,4,5', 'is_cash' => '0'),

        //     19 => array('name' => 'BPI S/A 761', 'description' => 'BPI S/A 761', 'code' => '1000050', 'branch_id' => '6,12', 'is_cash' => '0'),
        //     25 => array('name' => 'A/R UNOSHOPPH (P/L)', 'description' => 'A/R UNOSHOPPH (P/L)', 'code' => '1000125', 'branch_id' => '6,12', 'is_cash' => '0'),
        //     26 => array('name' => 'ADVERTISING & PROMOTION EXPENSE', 'description' => 'ADVERTISING & PROMOTION EXPENSE', 'code' => '6000073', 'branch_id' => '6,12', 'is_cash' => '0'),
        //     30 => array('name' => 'PR BGC BDO PHP SA 074', 'description' => 'PR BGC BDO PHP SA 074', 'code' => '1000036', 'branch_id' => '7,8,9,10,11,12', 'is_cash' => '0'),
        //     33 => array('name' => 'BDO UNO PREMIER NEW 074', 'description' => 'BDO UNO PREMIER NEW 074', 'code' => '1000069', 'branch_id' => '7,8,9,10,11,12', 'is_cash' => '0'),
        //     35 => array('name' => 'PAY PALL', 'description' => 'PAY PALL', 'code' => '1000126', 'branch_id' => '12', 'is_cash' => '0'),
        //     36 => array('name' => 'A/R LAZAMALL', 'description' => 'A/R LAZAMALL', 'code' => '1000129', 'branch_id' => '12', 'is_cash' => '0'),
        //     43 => array('name' => 'MBTC S/A 366', 'description' => 'MBTC S/A 366', 'code' => '1000049', 'branch_id' => '2,3,4,5,7,8,9,10,11', 'is_cash' => '0'),
        //     56 => array('name' => 'BDO NW ACCOUNT 5084', 'description' => 'BDO NW ACCOUNT 5084', 'code' => '1000039', 'branch_id' => '7,8,9,10,11', 'is_cash' => '0'),
        // ];

        $payment_methods = [
            1 => array('name' => 'CASH', 'description' => '1010002 - Cash - Undeposited Collections - UNO', 'code' => '1010002', 'company_id' => '3', 'branch_id' => '1,2,3,4,5,6', 'is_cash' => '3'),
            2 => array('name' => 'EW 076', 'description' => '1010501 - LO-CIB-Eastwest Bank- - UNO', 'code' => '1010501', 'company_id' => '3', 'branch_id' => '1,2,3,4,5,6', 'is_cash' => '0'),
            3 => array('name' => 'BDO 009', 'description' => '1010202 - LO-CIB-BDO UBS - UNO', 'code' => '1010202', 'company_id' => '3', 'branch_id' => '1,2,3,4,5,6', 'is_cash' => '0'),
            4 => array('name' => 'BDO 177', 'description' => '1010205 - LO-CIB-BDO UNO Premier Sales - UNO', 'code' => '1010205', 'company_id' => '3', 'branch_id' => '1,2,3,4,5,6', 'is_cash' => '0'),
            5 => array('name' => 'BDO 710', 'description' => '1010206 - LO-CIB-BDO Credit Card - UNO', 'code' => '1010206', 'company_id' => '3', 'branch_id' => '1,2,3,4,5,6', 'is_cash' => '0'),
            6 => array('name' => 'RCBC 089', 'description' => '1010400 - LO-CIB-RCBC - UNO', 'code' => '1010400', 'company_id' => '3', 'branch_id' => '1010400', 'is_cash' => '0'),
            7 => array('name' => 'UB 107', 'description' => '1010104 - LO-CIB-Union Bank VITO CRUZ - UNO', 'code' => '1010104', 'company_id' => '3', 'branch_id' => '1,2,3,4,5,6', 'is_cash' => '0'),
            8 => array('name' => 'UB 288', 'description' => '1010102 - LO-CIB-Union Bank COMMISSION - UNO', 'code' => '1010102', 'company_id' => '3', 'branch_id' => '1,2,3,4,5,6', 'is_cash' => '0'),
            9 => array('name' => 'SB 733', 'description' => '1010301 - LO-CIB-SB Current - UNO', 'code' => '1010301', 'company_id' => '3', 'branch_id' => '1,2,3,4,5,6', 'is_cash' => '0'),
            10 => array('name' => 'MBTC 366', 'description' => '1010602 - LO-CIB-Metrobank UBS SALES - UNO', 'code' => '1010602', 'company_id' => '3', 'branch_id' => '1,2,3,4,5,6', 'is_cash' => '0'),
            11 => array('name' => 'BPI 761', 'description' => '1010802 - LO-CIB-BPI UBC CREDIT CARD SALES - UNO', 'code' => '1010802', 'company_id' => '3', 'branch_id' => '1,2,3,4,5,6', 'is_cash' => '0'),
            12 => array('name' => 'AR Trade', 'description' => '1101001 - Accounts Receivable - Trade - UNO', 'code' => '1101001', 'company_id' => '3', 'branch_id' => '1,2,3,4,5,6', 'is_cash' => '0'),
            13 => array('name' => 'AR GCash', 'description' => '1101031 - Accounts Receivable - G-Cash - LOCAL', 'code' => '1101031', 'company_id' => '3', 'branch_id' => '1,2,3,4,5,6', 'is_cash' => '0'),
            14 => array('name' => 'AR LBC', 'description' => '1101029 - Accounts Receivable - LBC - LOCAL', 'code' => '1101029', 'company_id' => '3', 'branch_id' => '1,2,3,4,5,6', 'is_cash' => '0'),
            15 => array('name' => 'AR Lazmall', 'description' => '1101032 - Accounts Receivable - Lazmall - LOCAL', 'code' => '1101032', 'company_id' => '3', 'branch_id' => '1,2,3,4,5,6', 'is_cash' => '0'),
            16 => array('name' => 'AR Paynamics', 'description' => '1101030 - Accounts Receivable - Paynamics - LOCAL', 'code' => '1101030', 'company_id' => '3', 'branch_id' => '1,2,3,4,5,6', 'is_cash' => '0'),
            17 => array('name' => 'Contra Commission', 'description' => '6010481 - OPE - Commission - Contra Commission PHP - LOCAL', 'code' => '6010481', 'company_id' => '3', 'branch_id' => '1,2,3,4,5,6', 'is_cash' => '0'),
            18 => array('name' => 'Commission GC', 'description' => '6010441 - OPE-Commission - GC PHP - LOCAL', 'code' => '6010441', 'company_id' => '3', 'branch_id' => '1,2,3,4,5,6', 'is_cash' => '0'),

            19 => array('name' => 'CASH', 'description' => '1010002 - Cash - Undeposited Collections - PREMIER', 'code' => '1010002', 'company_id' => '2', 'branch_id' => '7,8,9,10,11,12', 'is_cash' => '1'),
            20 => array('name' => 'EW 076**', 'description' => 'Unknown', 'code' => '1010501', 'company_id' => '2', 'branch_id' => '7,8,9,10,11,12', 'is_cash' => '0'),
            21 => array('name' => 'BDO 009**', 'description' => 'Unknown', 'code' => '1000035', 'company_id' => '2', 'branch_id' => '7,8,9,10,11,12', 'is_cash' => '0'),
            22 => array('name' => 'BDO 074', 'description' => '1020201 - PR-CIB-BDO CREDIT CARD - PREMIER', 'code' => '1020201', 'company_id' => '2', 'branch_id' => '7,8,9,10,11,12', 'is_cash' => '0'),
            23 => array('name' => 'BDO 084', 'description' => '1020202 - PR-CIB-BDO PREMIER INT\'L - PREMIER', 'code' => '1020202', 'company_id' => '2', 'branch_id' => '7,8,9,10,11,12', 'is_cash' => '0'),
            24 => array('name' => 'UB 608', 'description' => '1020106 - PR-CIB-Union Bank BGC - PREMIER', 'code' => '1020106', 'company_id' => '2', 'branch_id' => '7,8,9,10,11,12', 'is_cash' => '0'),
            25 => array('name' => 'BDO 710**', 'description' => 'Unknown', 'code' => '1010206', 'company_id' => '2', 'branch_id' => '7,8,9,10,11,12', 'is_cash' => '0'),
            26 => array('name' => 'MBTC 366**', 'description' => 'Unknown', 'code' => '1010602', 'company_id' => '2', 'branch_id' => '7,8,9,10,11,12', 'is_cash' => '0'),
            27 => array('name' => 'BPI 761**', 'description' => 'Unknown', 'code' => '1010802', 'company_id' => '2', 'branch_id' => '7,8,9,10,11,12', 'is_cash' => '0'),
            28 => array('name' => 'Promo Items', 'description' => '6010121 - OPE-Promotional Items PHP - PREMIER', 'code' => '6010121', 'company_id' => '2', 'branch_id' => '7,8,9,10,11,12', 'is_cash' => '0'),
            29 => array('name' => 'AR Trade', 'description' => '1101001 - Accounts Receivable - Trade - PREMIER', 'code' => '1101001', 'company_id' => '2', 'branch_id' => '7,8,9,10,11,12', 'is_cash' => '0'),
            30 => array('name' => 'AR GCash', 'description' => '1101031 - Accounts Receivable - G-Cash - PREMIER', 'code' => '1101031', 'company_id' => '2', 'branch_id' => '7,8,9,10,11,12', 'is_cash' => '0'),
            31 => array('name' => 'AR LBC', 'description' => '1101029 - Accounts Receivable - LBC - PREMIER', 'code' => '1101029', 'company_id' => '2', 'branch_id' => '7,8,9,10,11,12', 'is_cash' => '0'),
            32 => array('name' => 'AR Lazmall', 'description' => '1101032 - Accounts Receivable - Lazmall - PREMIER', 'code' => '1101032', 'company_id' => '2', 'branch_id' => '7,8,9,10,11,12', 'is_cash' => '0'),
            33 => array('name' => 'AR Paynamics', 'description' => '1101030 - Accounts Receivable - Paynamics - PREMIER', 'code' => '1101030', 'company_id' => '2', 'branch_id' => '7,8,9,10,11,12', 'is_cash' => '0'),
            34 => array('name' => 'Unknown**', 'description' => 'Unknown', 'code' => '6010481', 'company_id' => '2', 'branch_id' => '7,8,9,10,11,12', 'is_cash' => '0'),
        ];

        foreach($payment_methods as $key => $payment_method) {
            PaymentMethod::create([
                'uuid' => Str::uuid(),
                'name' => $payment_method['name'],
                'description' => $payment_method['description'],
                'code' => $payment_method['code'],
                'company_id' => $payment_method['company_id'],
                'branch_id' => $payment_method['branch_id'],
                'is_cash' => $payment_method['is_cash'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
