<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = [
            1 => array('name' => 'NCR - 1st District'),
            2 => array('name' => 'NCR - 2nd District'),
            3 => array('name' => 'NCR - 3rd District'),
            4 => array('name' => 'NCR - 4th District'),
            5 => array('name' => 'Abra'),
            6 => array('name' => 'Agusan del Norte'),
            7 => array('name' => 'Agusan del Sur'),
            8 => array('name' => 'Aklan'),
            9 => array('name' => 'Albay'),
            10 => array('name' => 'Antique'),
            11 => array('name' => 'Apayao'),
            12 => array('name' => 'Aurora'),
            13 => array('name' => 'Basilan'),
            14 => array('name' => 'Bataan'),
            15 => array('name' => 'Batanes'),
            16 => array('name' => 'Batangas'),
            17 => array('name' => 'Benguet'),
            18 => array('name' => 'Biliran'),
            19 => array('name' => 'Bohol'),
            20 => array('name' => 'Bukidnon'),
            21 => array('name' => 'Bulacan'),
            22 => array('name' => 'Cagayan'),
            23 => array('name' => 'Camarines Norte'),
            24 => array('name' => 'Camarines Sur'),
            25 => array('name' => 'Camiguin'),
            26 => array('name' => 'Capiz'),
            27 => array('name' => 'Catanduanes'),
            28 => array('name' => 'Cavite'),
            29 => array('name' => 'Cebu'),
            30 => array('name' => 'City of Cotabato - Special Province'),
            31 => array('name' => 'City of Isabela - Special Province'),
            32 => array('name' => 'Cotabato'),
            33 => array('name' => 'Davao de Oro - Compostela Valley'),
            34 => array('name' => 'Davao del Norte'),
            35 => array('name' => 'Davao del Sur'),
            36 => array('name' => 'Davao Occidental'),
            37 => array('name' => 'Davao Oriental'),
            38 => array('name' => 'Dinagat Islands'),
            39 => array('name' => 'Eastern Samar'),
            40 => array('name' => 'Guimaras'),
            41 => array('name' => 'Ifugao'),
            42 => array('name' => 'Ilocos Norte'),
            43 => array('name' => 'Ilocos Sur'),
            44 => array('name' => 'Iloilo'),
            45 => array('name' => 'Isabela'),
            46 => array('name' => 'Kalinga'),
            47 => array('name' => 'La Union'),
            48 => array('name' => 'Laguna'),
            49 => array('name' => 'Lanao del Norte'),
            50 => array('name' => 'Lanao del Sur'),
            51 => array('name' => 'Leyte'),
            52 => array('name' => 'Maguindanao'),
            53 => array('name' => 'Marinduque'),
            54 => array('name' => 'Masbate'),
            55 => array('name' => 'Misamis Occidental'),
            56 => array('name' => 'Misamis Oriental'),
            57 => array('name' => 'Mountain Province'),
            58 => array('name' => 'Negros Occidental'),
            59 => array('name' => 'Negros Oriental'),
            60 => array('name' => 'Northern Samar'),
            61 => array('name' => 'Nueva Ecija'),
            62 => array('name' => 'Nueva Vizcaya'),
            63 => array('name' => 'Occidental Mindoro'),
            64 => array('name' => 'Oriental Mindoro'),
            65 => array('name' => 'Palawan'),
            66 => array('name' => 'Pampanga'),
            67 => array('name' => 'Pangasinan'),
            68 => array('name' => 'Quezon'),
            69 => array('name' => 'Quirino'),
            70 => array('name' => 'Rizal'),
            71 => array('name' => 'Romblon'),
            72 => array('name' => 'Samar'),
            73 => array('name' => 'Sarangani'),
            74 => array('name' => 'Siquijor'),
            75 => array('name' => 'Sorsogon'),
            76 => array('name' => 'South Cotabato'),
            77 => array('name' => 'Southern Leyte'),
            78 => array('name' => 'Sultan Kudarat'),
            79 => array('name' => 'Sulu'),
            80 => array('name' => 'Surigao del Norte'),
            81 => array('name' => 'Surigao del Sur'),
            82 => array('name' => 'Tarlac'),
            83 => array('name' => 'Tawi-Tawi'),
            84 => array('name' => 'Zambales'),
            85 => array('name' => 'Zamboanga del Norte'),
            86 => array('name' => 'Zamboanga del Sur'),
            87 => array('name' => 'Zamboanga Sibugay')
            
  
        ];

        foreach($provinces as $key => $province) {
            Province::create([
                'uuid' => Str::uuid(),
                'name' => $province['name'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
