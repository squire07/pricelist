<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\EmployeeDetails;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeeDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $details = [
    
            1 => array('employee_id' => '1', 'tin' => NULL, 'phic' => NULL, 'sss' => NULL, 'hdmf' => NULL, 'national_id' => NULL, 'umid' => NULL, 'passport' => NULL, 'drivers_license' => NULL, 'house_number' => NULL, 'street' => 'KANLURAN 2', 'barangay' => 'ESTRELLA', 'city' => 'NAUJAN', 'province' => 'ORIENTAL MINDORO', 'zip_code' => NULL, 'contact_details' => '09500337018', 'emergency_contact_name' => 'RICHARD PAALA', 'emergency_contact_number' => NULL, 'employee_type' => 'PROBATIONARY', 'pay_frequency' => 'DAILY', 'date_hired' => '01/10/2024', 'date_separated' => NULL, 'basic_pay' => '395', 'rate_per_day' => '0', 'rate_per_hour' => '0', 'ot_rate_per_hour' => '0', 'remarks' => NULL),
            2 => array('employee_id' => '2', 'tin' => NULL, 'phic' => NULL, 'sss' => NULL, 'hdmf' => NULL, 'national_id' => NULL, 'umid' => NULL, 'passport' => NULL, 'drivers_license' => NULL, 'house_number' => NULL, 'street' => 'NONE', 'barangay' => 'BALITE', 'city' => 'CALAPAN CITY', 'province' => 'ORIENTAL MINDORO', 'zip_code' => NULL, 'contact_details' => '09082504094', 'emergency_contact_name' => NULL, 'emergency_contact_number' => NULL, 'employee_type' => 'REGULAR', 'pay_frequency' => 'MONTHLY', 'date_hired' => '05/22/2023', 'date_separated' => NULL, 'basic_pay' => '25000', 'rate_per_day' => '0', 'rate_per_hour' => '0', 'ot_rate_per_hour' => '0', 'remarks' => NULL),
            3 => array('employee_id' => '3', 'tin' => NULL, 'phic' => NULL, 'sss' => NULL, 'hdmf' => NULL, 'national_id' => NULL, 'umid' => NULL, 'passport' => NULL, 'drivers_license' => NULL, 'house_number' => NULL, 'street' => 'NONE', 'barangay' => 'GLORIA', 'city' => 'SAN ANTONIO', 'province' => 'ORIENTAL MINDORO', 'zip_code' => NULL, 'contact_details' => '09991952684', 'emergency_contact_name' => NULL, 'emergency_contact_number' => NULL, 'employee_type' => 'REGULAR', 'pay_frequency' => 'DAILY', 'date_hired' => '03/16/2023', 'date_separated' => NULL, 'basic_pay' => '450', 'rate_per_day' => '0', 'rate_per_hour' => '0', 'ot_rate_per_hour' => '0', 'remarks' => NULL),
            4 => array('employee_id' => '4', 'tin' => NULL, 'phic' => NULL, 'sss' => NULL, 'hdmf' => NULL, 'national_id' => NULL, 'umid' => NULL, 'passport' => NULL, 'drivers_license' => NULL, 'house_number' => NULL, 'street' => 'NONE', 'barangay' => 'BAGONG BAYAN', 'city' => 'BONGABONG', 'province' => 'ORIENTAL MINDORO', 'zip_code' => NULL, 'contact_details' => '09776506882', 'emergency_contact_name' => NULL, 'emergency_contact_number' => NULL, 'employee_type' => 'REGULAR', 'pay_frequency' => 'DAILY', 'date_hired' => '05/18/2023', 'date_separated' => NULL, 'basic_pay' => '500', 'rate_per_day' => '0', 'rate_per_hour' => '0', 'ot_rate_per_hour' => '0', 'remarks' => NULL),
            5 => array('employee_id' => '5', 'tin' => NULL, 'phic' => NULL, 'sss' => NULL, 'hdmf' => NULL, 'national_id' => NULL, 'umid' => NULL, 'passport' => NULL, 'drivers_license' => NULL, 'house_number' => NULL, 'street' => 'NONE', 'barangay' => 'POBLACION I', 'city' => 'VICTORIA', 'province' => 'ORIENTAL MINDORO', 'zip_code' => NULL, 'contact_details' => '09567343067', 'emergency_contact_name' => NULL, 'emergency_contact_number' => NULL, 'employee_type' => 'REGULAR', 'pay_frequency' => 'DAILY', 'date_hired' => '07/01/2023', 'date_separated' => NULL, 'basic_pay' => '500', 'rate_per_day' => '0', 'rate_per_hour' => '0', 'ot_rate_per_hour' => '0', 'remarks' => NULL),
            6 => array('employee_id' => '6', 'tin' => NULL, 'phic' => NULL, 'sss' => NULL, 'hdmf' => NULL, 'national_id' => NULL, 'umid' => NULL, 'passport' => NULL, 'drivers_license' => NULL, 'house_number' => NULL, 'street' => 'NONE', 'barangay' => 'MAHAL NA PANGALAN', 'city' => 'CALAPAN CITY', 'province' => 'ORIENTAL MINDORO', 'zip_code' => NULL, 'contact_details' => '09774731972', 'emergency_contact_name' => NULL, 'emergency_contact_number' => NULL, 'employee_type' => 'REGULAR', 'pay_frequency' => 'DAILY', 'date_hired' => '08/28/2023', 'date_separated' => NULL, 'basic_pay' => '500', 'rate_per_day' => '0', 'rate_per_hour' => '0', 'ot_rate_per_hour' => '0', 'remarks' => NULL),
            7 => array('employee_id' => '7', 'tin' => NULL, 'phic' => NULL, 'sss' => NULL, 'hdmf' => NULL, 'national_id' => NULL, 'umid' => NULL, 'passport' => NULL, 'drivers_license' => NULL, 'house_number' => NULL, 'street' => 'NONE', 'barangay' => 'MASIPIT', 'city' => 'CALAPAN CITY', 'province' => 'ORIENTAL MINDORO', 'zip_code' => NULL, 'contact_details' => '09918095793', 'emergency_contact_name' => NULL, 'emergency_contact_number' => NULL, 'employee_type' => 'REGULAR', 'pay_frequency' => 'DAILY', 'date_hired' => '10/12/2023', 'date_separated' => NULL, 'basic_pay' => '550', 'rate_per_day' => '0', 'rate_per_hour' => '0', 'ot_rate_per_hour' => '0', 'remarks' => NULL),
            8 => array('employee_id' => '8', 'tin' => NULL, 'phic' => NULL, 'sss' => NULL, 'hdmf' => NULL, 'national_id' => NULL, 'umid' => NULL, 'passport' => NULL, 'drivers_license' => NULL, 'house_number' => NULL, 'street' => 'NONE', 'barangay' => 'SAN ISIDRO', 'city' => 'NAUJAN', 'province' => 'ORIENTAL MINDORO', 'zip_code' => NULL, 'contact_details' => '09094330428', 'emergency_contact_name' => NULL, 'emergency_contact_number' => NULL, 'employee_type' => 'REGULAR', 'pay_frequency' => 'DAILY', 'date_hired' => '05/22/2023', 'date_separated' => NULL, 'basic_pay' => '500', 'rate_per_day' => '0', 'rate_per_hour' => '0', 'ot_rate_per_hour' => '0', 'remarks' => NULL),
            9 => array('employee_id' => '9', 'tin' => NULL, 'phic' => NULL, 'sss' => NULL, 'hdmf' => NULL, 'national_id' => NULL, 'umid' => NULL, 'passport' => NULL, 'drivers_license' => NULL, 'house_number' => NULL, 'street' => 'PAGKAKAISA', 'barangay' => 'PAGKAKAISA', 'city' => 'NAUJAN', 'province' => 'ORIENTAL MINDORO', 'zip_code' => NULL, 'contact_details' => '09365060532', 'emergency_contact_name' => NULL, 'emergency_contact_number' => NULL, 'employee_type' => 'PROBATIONARY', 'pay_frequency' => 'DAILY', 'date_hired' => '01/10/2024', 'date_separated' => NULL, 'basic_pay' => '395', 'rate_per_day' => '0', 'rate_per_hour' => '0', 'ot_rate_per_hour' => '0', 'remarks' => NULL),
            10 => array('employee_id' => '10', 'tin' => NULL, 'phic' => NULL, 'sss' => NULL, 'hdmf' => NULL, 'national_id' => NULL, 'umid' => NULL, 'passport' => NULL, 'drivers_license' => NULL, 'house_number' => NULL, 'street' => 'DAO', 'barangay' => 'SAN ISIDRO', 'city' => 'NAUJAN', 'province' => 'ORIENTAL MINDORO', 'zip_code' => NULL, 'contact_details' => '09090000000', 'emergency_contact_name' => NULL, 'emergency_contact_number' => NULL, 'employee_type' => 'REGULAR', 'pay_frequency' => 'DAILY', 'date_hired' => '01/01/2021', 'date_separated' => NULL, 'basic_pay' => '395', 'rate_per_day' => '0', 'rate_per_hour' => '0', 'ot_rate_per_hour' => '0', 'remarks' => NULL),
            11 => array('employee_id' => '11', 'tin' => NULL, 'phic' => NULL, 'sss' => NULL, 'hdmf' => NULL, 'national_id' => NULL, 'umid' => NULL, 'passport' => NULL, 'drivers_license' => NULL, 'house_number' => NULL, 'street' => 'N/A', 'barangay' => 'SANTO NIÑO', 'city' => 'NAUJAN', 'province' => 'ORIENTAL MINDORO', 'zip_code' => NULL, 'contact_details' => '09770132721', 'emergency_contact_name' => NULL, 'emergency_contact_number' => NULL, 'employee_type' => 'CASUAL', 'pay_frequency' => 'DAILY', 'date_hired' => '02/09/2024', 'date_separated' => NULL, 'basic_pay' => '395', 'rate_per_day' => '0', 'rate_per_hour' => '0', 'ot_rate_per_hour' => '0', 'remarks' => NULL),
            12 => array('employee_id' => '12', 'tin' => NULL, 'phic' => NULL, 'sss' => NULL, 'hdmf' => NULL, 'national_id' => NULL, 'umid' => NULL, 'passport' => NULL, 'drivers_license' => NULL, 'house_number' => NULL, 'street' => 'NONE', 'barangay' => 'SANTA MARIA', 'city' => 'NAUJAN', 'province' => 'ORIENTAL MINDORO', 'zip_code' => NULL, 'contact_details' => '09486698785', 'emergency_contact_name' => NULL, 'emergency_contact_number' => NULL, 'employee_type' => 'CASUAL', 'pay_frequency' => 'DAILY', 'date_hired' => '02/02/2024', 'date_separated' => NULL, 'basic_pay' => '395', 'rate_per_day' => '0', 'rate_per_hour' => '0', 'ot_rate_per_hour' => '0', 'remarks' => NULL),
            13 => array('employee_id' => '13', 'tin' => NULL, 'phic' => NULL, 'sss' => NULL, 'hdmf' => NULL, 'national_id' => NULL, 'umid' => NULL, 'passport' => NULL, 'drivers_license' => NULL, 'house_number' => NULL, 'street' => 'NONE', 'barangay' => 'SAMPAGUITA', 'city' => 'NAUJAN', 'province' => 'ORIENTAL MINDORO', 'zip_code' => NULL, 'contact_details' => '09096474849', 'emergency_contact_name' => NULL, 'emergency_contact_number' => NULL, 'employee_type' => 'PROBATIONARY', 'pay_frequency' => 'DAILY', 'date_hired' => '07/08/2023', 'date_separated' => NULL, 'basic_pay' => '395', 'rate_per_day' => '0', 'rate_per_hour' => '0', 'ot_rate_per_hour' => '0', 'remarks' => NULL),
            14 => array('employee_id' => '14', 'tin' => NULL, 'phic' => NULL, 'sss' => NULL, 'hdmf' => NULL, 'national_id' => NULL, 'umid' => NULL, 'passport' => NULL, 'drivers_license' => NULL, 'house_number' => NULL, 'street' => 'NONE', 'barangay' => 'BARCENAGA', 'city' => 'NAUJAN', 'province' => 'ORIENTAL MINDORO', 'zip_code' => NULL, 'contact_details' => '09922071694', 'emergency_contact_name' => NULL, 'emergency_contact_number' => NULL, 'employee_type' => 'PROBATIONARY', 'pay_frequency' => 'DAILY', 'date_hired' => '09/15/2023', 'date_separated' => NULL, 'basic_pay' => '395', 'rate_per_day' => '0', 'rate_per_hour' => '0', 'ot_rate_per_hour' => '0', 'remarks' => NULL),
            15 => array('employee_id' => '15', 'tin' => NULL, 'phic' => NULL, 'sss' => NULL, 'hdmf' => NULL, 'national_id' => NULL, 'umid' => NULL, 'passport' => NULL, 'drivers_license' => NULL, 'house_number' => NULL, 'street' => 'NONE', 'barangay' => 'MELGAR A', 'city' => 'NAUJAN', 'province' => 'ORIENTAL MINDORO', 'zip_code' => NULL, 'contact_details' => '09621380947', 'emergency_contact_name' => NULL, 'emergency_contact_number' => NULL, 'employee_type' => 'PROBATIONARY', 'pay_frequency' => 'DAILY', 'date_hired' => '02/13/2024', 'date_separated' => NULL, 'basic_pay' => '395', 'rate_per_day' => '0', 'rate_per_hour' => '0', 'ot_rate_per_hour' => '0', 'remarks' => NULL),
            16 => array('employee_id' => '16', 'tin' => NULL, 'phic' => NULL, 'sss' => NULL, 'hdmf' => NULL, 'national_id' => NULL, 'umid' => NULL, 'passport' => NULL, 'drivers_license' => NULL, 'house_number' => '66', 'street' => 'PUROK 1B', 'barangay' => 'DEL PILAR', 'city' => 'NAUJAN', 'province' => 'ORIENTAL MINDORO', 'zip_code' => NULL, 'contact_details' => '09158478650', 'emergency_contact_name' => NULL, 'emergency_contact_number' => NULL, 'employee_type' => 'PROBATIONARY', 'pay_frequency' => 'DAILY', 'date_hired' => '02/16/2024', 'date_separated' => NULL, 'basic_pay' => '395', 'rate_per_day' => '0', 'rate_per_hour' => '0', 'ot_rate_per_hour' => '0', 'remarks' => NULL)


        ];

        foreach($details as $key => $detail) {
            EmployeeDetails::create([
                'uuid' => Str::uuid(),
                'employee_id' => $detail['employee_id'],
                'tin' => $detail['tin'],
                'phic' => $detail['phic'],
                'sss' => $detail['sss'],
                'hdmf' => $detail['hdmf'],
                'national_id' => $detail['national_id'],
                'umid' => $detail['umid'],
                'passport' => $detail['passport'],
                'drivers_license' => $detail['drivers_license'],
                'house_number' => $detail['house_number'],
                'zip_code' => $detail['zip_code'],
                'street' => $detail['street'],
                'barangay' => $detail['barangay'], 
                'city' => $detail['city'],
                'province' => $detail['province'],
                'contact_details' => $detail['contact_details'],
                'emergency_contact_name' => $detail['emergency_contact_name'], 
                'emergency_contact_number' => $detail['emergency_contact_number'], 
                'employee_type' => $detail['employee_type'],
                'date_hired' => $detail['date_hired'],
                'date_separated' => $detail['date_separated'],
                'pay_frequency' => $detail['pay_frequency'], 
                'basic_pay' => $detail['basic_pay'],
                'rate_per_day' => $detail['rate_per_day'],
                'rate_per_hour' => $detail['rate_per_hour'],
                'ot_rate_per_hour' => $detail['ot_rate_per_hour'], 
                'remarks' => $detail['remarks'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
