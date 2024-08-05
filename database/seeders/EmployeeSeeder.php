<?php

namespace Database\Seeders;

use App\Models\Employees;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            1 => array('code' => 'FZEMP0001', 'first_name' => 'PATRICIA HANNAH NICOLE', 'last_name' => 'FACTO', 'middle_name' => 'SANONE', 'full_name' => 'PATRICIA HANNAH NICOLE SANONE FACTO', 'gender' => 'FEMALE', 'civil_status' => 'SINGLE', 'birthdate' => '12/26/1993', 'age' => '31', 'height' => '', 'weight' => '', 'religion' => 'ROMAN CATOLIC', 'nationality' => NULL, 'company_id' => 1, 'department_id' => 1, 'role_id' => 3, 'agent_category' => 4, 'images' => NULL),
            2 => array('code' => 'FZEMP0002', 'first_name' => 'NOEL', 'last_name' => 'ROMASANTA', 'middle_name' => '', 'full_name' => 'NOEL ROMASANTA', 'gender' => 'MALE', 'civil_status' => 'MARRIED', 'birthdate' => '10/09/1980', 'age' => '44', 'height' => '', 'weight' => '', 'religion' => NULL, 'nationality' => NULL, 'company_id' => 1, 'department_id' => 3, 'role_id' => 5, 'agent_category' => 1, 'images' => NULL),
            3 => array('code' => 'FZEMP0003', 'first_name' => 'JEMAR', 'last_name' => 'BANAN', 'middle_name' => '', 'full_name' => 'JEMAR BANAN', 'gender' => 'MALE', 'civil_status' => 'SINGLE', 'birthdate' => '07/07/1989', 'age' => '35', 'height' => '', 'weight' => '', 'religion' => NULL, 'nationality' => NULL, 'company_id' => 1, 'department_id' => 2, 'role_id' => 5, 'agent_category' => 1, 'images' => NULL),
            4 => array('code' => 'FZEMP0004', 'first_name' => 'LINO', 'last_name' => 'PANTALLANO', 'middle_name' => '', 'full_name' => 'LINO PANTALLANO', 'gender' => 'MALE', 'civil_status' => 'MARRIED', 'birthdate' => '01/08/1987', 'age' => '37', 'height' => '', 'weight' => '0', 'religion' => NULL, 'nationality' => NULL, 'company_id' => 1, 'department_id' => 2, 'role_id' => 5, 'agent_category' => 4, 'images' => NULL),
            5 => array('code' => 'FZEMP0005', 'first_name' => 'HARBY', 'last_name' => 'SALAZAR', 'middle_name' => '', 'full_name' => 'HARBY SALAZAR', 'gender' => 'MALE', 'civil_status' => 'MARRIED', 'birthdate' => '01/10/1984', 'age' => '40', 'height' => '', 'weight' => '0', 'religion' => NULL, 'nationality' => NULL, 'company_id' => 1, 'department_id' => 2, 'role_id' => 5, 'agent_category' => 1, 'images' => NULL),
            6 => array('code' => 'FZEMP0006', 'first_name' => 'CHRISTIAN', 'last_name' => 'CORDERO', 'middle_name' => '', 'full_name' => 'CHRISTIAN CORDERO', 'gender' => 'MALE', 'civil_status' => 'MARRIED', 'birthdate' => '12/25/1979', 'age' => '45', 'height' => '', 'weight' => '', 'religion' => NULL, 'nationality' => NULL, 'company_id' => 1, 'department_id' => 2, 'role_id' => 5, 'agent_category' => 1, 'images' => NULL),
            7 => array('code' => 'FZEMP0007', 'first_name' => 'JUAN', 'last_name' => 'ANDULAN', 'middle_name' => '', 'full_name' => 'JUAN ANDULAN', 'gender' => 'MALE', 'civil_status' => 'MARRIED', 'birthdate' => '06/24/1981', 'age' => '43', 'height' => '', 'weight' => '', 'religion' => NULL, 'nationality' => NULL, 'company_id' => 1, 'department_id' => 2, 'role_id' => 5, 'agent_category' => 1, 'images' => NULL),
            8 => array('code' => 'FZEMP0008', 'first_name' => 'ANA', 'last_name' => 'SANGAT', 'middle_name' => '', 'full_name' => 'ANA SANGAT', 'gender' => 'FEMALE', 'civil_status' => 'SINGLE', 'birthdate' => '01/07/1994', 'age' => '30', 'height' => '', 'weight' => '', 'religion' => NULL, 'nationality' => NULL, 'company_id' => 1, 'department_id' => 2, 'role_id' => 5, 'agent_category' => 4, 'images' => NULL),
            9 => array('code' => 'FZEMP0009', 'first_name' => 'IRENEO', 'last_name' => 'VIADO', 'middle_name' => '', 'full_name' => 'IRENEO VIADO', 'gender' => 'MALE', 'civil_status' => 'MARRIED', 'birthdate' => '06/28/1976', 'age' => '48', 'height' => '', 'weight' => '0', 'religion' => NULL, 'nationality' => NULL, 'company_id' => 1, 'department_id' => 2, 'role_id' => 4, 'agent_category' => 2, 'images' => NULL),
            10 => array('code' => 'FZEMP0010', 'first_name' => 'ACE', 'last_name' => 'DE GUZMAN', 'middle_name' => '', 'full_name' => 'ACE DE GUZMAN', 'gender' => 'MALE', 'civil_status' => 'SINGLE', 'birthdate' => '05/25/2001', 'age' => '23', 'height' => '', 'weight' => '0', 'religion' => NULL, 'nationality' => NULL, 'company_id' => 1, 'department_id' => 2, 'role_id' => 6, 'agent_category' => 4, 'images' => NULL),
            11 => array('code' => 'FZEMP0011', 'first_name' => 'LIEZEL', 'last_name' => 'ZACARIAS', 'middle_name' => '', 'full_name' => 'LIEZEL ZACARIAS', 'gender' => 'FEMALE', 'civil_status' => 'MARRIED', 'birthdate' => '10/14/1983', 'age' => '41', 'height' => '', 'weight' => '0', 'religion' => NULL, 'nationality' => NULL, 'company_id' => 1, 'department_id' => 1, 'role_id' => 3, 'agent_category' => 4, 'images' => NULL),
            12 => array('code' => 'FZEMP0012', 'first_name' => 'JACK JUNE', 'last_name' => 'FABELLON', 'middle_name' => '', 'full_name' => 'JACK JUNE FABELLON', 'gender' => 'MALE', 'civil_status' => 'SINGLE', 'birthdate' => '12/01/1991', 'age' => '33', 'height' => '', 'weight' => '0', 'religion' => NULL, 'nationality' => NULL, 'company_id' => 1, 'department_id' => 2, 'role_id' => 6, 'agent_category' => 4, 'images' => NULL),
            13 => array('code' => 'FZEMP0013', 'first_name' => 'ANNALYN', 'last_name' => 'DELIZO', 'middle_name' => '', 'full_name' => 'ANNALYN DELIZO', 'gender' => 'FEMALE', 'civil_status' => 'SINGLE', 'birthdate' => '07/18/1993', 'age' => '31', 'height' => '', 'weight' => '0', 'religion' => NULL, 'nationality' => NULL, 'company_id' => 1, 'department_id' => 1, 'role_id' => 3, 'agent_category' => 4, 'images' => NULL),
            14 => array('code' => 'FZEMP0014', 'first_name' => 'MELJAY', 'last_name' => 'SAMARITA', 'middle_name' => '', 'full_name' => 'MELJAY SAMARITA', 'gender' => 'MALE', 'civil_status' => 'SINGLE', 'birthdate' => '04/23/1991', 'age' => '33', 'height' => '', 'weight' => '0', 'religion' => NULL, 'nationality' => NULL, 'company_id' => 1, 'department_id' => 2, 'role_id' => 4, 'agent_category' => 4, 'images' => NULL),
            15 => array('code' => 'FZEMP0015', 'first_name' => 'MAAN ROVELYN', 'last_name' => 'OLIVA', 'middle_name' => '', 'full_name' => 'MAAN ROVELYN OLIVA', 'gender' => 'FEMALE', 'civil_status' => 'SINGLE', 'birthdate' => '11/03/1995', 'age' => '29', 'height' => '', 'weight' => '0', 'religion' => NULL, 'nationality' => NULL, 'company_id' => 1, 'department_id' => 1, 'role_id' => 3, 'agent_category' => 4, 'images' => NULL),
            16 => array('code' => 'FZEMP0016', 'first_name' => 'NOEMI', 'last_name' => 'RABINO', 'middle_name' => 'MELENDREZ', 'full_name' => 'NOEMI MELENDREZ RABINO', 'gender' => 'FEMALE', 'civil_status' => 'SINGLE', 'birthdate' => '07/09/1993', 'age' => '31', 'height' => '', 'weight' => '', 'religion' => NULL, 'nationality' => NULL, 'company_id' => 1, 'department_id' => 1, 'role_id' => 3, 'agent_category' => 4, 'images' => NULL)            
            
        ];

        foreach($employees as $key => $employee) {
            Employees::create([
                'uuid' => Str::uuid(),
                'code' => $employee['code'],
                'first_name' => $employee['first_name'],
                'last_name' => $employee['last_name'],
                'middle_name' => $employee['middle_name'],
                'full_name' => $employee['full_name'],
                'gender' => $employee['gender'],
                'civil_status' => $employee['civil_status'],
                'birthdate' => $employee['birthdate'],
                'age' => $employee['age'],
                'height' => $employee['height'],
                'weight' => $employee['weight'],
                'religion' => $employee['religion'],
                'nationality' => $employee['nationality'], 
                'company_id' => $employee['company_id'],
                'department_id' => $employee['department_id'],
                'role_id' => $employee['role_id'],
                'agent_category' => $employee['agent_category'], 
                'images' => $employee['images'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
