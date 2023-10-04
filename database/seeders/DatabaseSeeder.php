<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Office;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('offices')->insert([
            ['name' => 'CMO - Permits & Licenses Division'],
            ['name' => 'City Health Office'],
            ['name' => 'City Treasurer Office'],
            ['name' => 'City Engineering Office'],
            ['name' => 'Bureau of Fire Protection'],
            ['name' => 'Information and Communications Technology Office']
        ]);
        
        $pld = Office::where('name', 'CMO - Permits & Licenses Division')->first();
        $cho = Office::where('name', 'City Health Office')->first();
        $cto = Office::where('name', 'City Treasurer Office')->first();
        $ceo = Office::where('name', 'City Engineering Office')->first();
        $bfp = Office::where('name', 'Bureau of Fire Protection')->first();
        $icto = Office::where('name', 'Information and Communications Technology Office')->first();
        
        DB::table('users')->insert([
            [
                'office_id' => $pld->office_id,
                'name' => 'CMO - PLD user',
                'username' => 'pld',
                'password' => bcrypt('password')

            ],
            
            [
                'office_id' => $cho->office_id,
                'name' => 'CHO user',
                'username' => 'cho',
                'password' => bcrypt('password')
            ],
            
            [
                'office_id' => $cto->office_id,
                'name' => 'CTO user',
                'username' => 'cto',
                'password' => bcrypt('password')
            ],
            
            [
                'office_id' => $ceo->office_id,
                'name' => 'CEO user',
                'username' => 'ceo',
                'password' => bcrypt('password')
            ],
            
            [
                'office_id' => $bfp->office_id,
                'name' => 'BFP user',
                'username' => 'bfp',
                'password' => bcrypt('password')
            ],
            
            [
                'office_id' => $icto->office_id,
                'name' => 'Admin',
                'username' => 'admin',
                'password' => bcrypt('Admin1234')
            ]
        ]);

        DB::table('requirements')->insert([
            [
                'office_id' => $pld->office_id,
                'requirement' => "No Mayor's Permit to Operate Business presented during inspection"
            ],

            [
                'office_id' => $cho->office_id,
                'requirement' => "No Sanitary Permit presented during inspection"
            ],

            [
                'office_id' => $cho->office_id,
                'requirement' => "No Health Certificate of Employees/Foodhandlers presented during inspection"
            ],

            [
                'office_id' => $cho->office_id,
                'requirement' => "No Health Certificate of owner presented during inspection"
            ],

            [
                'office_id' => $cho->office_id,
                'requirement' => "Expired Health Certificate of owner"
            ],

            [
                'office_id' => $cho->office_id,
                'requirement' => "Expired Health Certificate of Employees/Foodhandlers"
            ],

            [
                'office_id' => $bfp->office_id,
                'requirement' => "No fire extinguisher/down-pressured fire extinguisher/Non-functioning emergency lights"
            ],

            [
                'office_id' => $bfp->office_id,
                'requirement' => "Obstructed Fire Exit"
            ],

            [
                'office_id' => $bfp->office_id,
                'requirement' => "Provide/No directional sign of Fire Exits"
            ],

            [
                'office_id' => $bfp->office_id,
                'requirement' => "Provide opening at window of sleeping rooms"
            ],

            [
                'office_id' => $ceo->office_id,
                'requirement' => "Improper electrical wiring installations"
            ],

            [
                'office_id' => $ceo->office_id,
                'requirement' => "Hanging electrical wires/uncovered junction boxes"
            ],

            [
                'office_id' => $pld->office_id,
                'requirement' => "No Individual Mayor's Permit (Working Permit) of employees"
            ]
        ]);

        //addresses seeds

        DB::table('addresses')->insert([
            [
                'brgy' => 'Brgy. 1, San Lorenzo',
                'brgy_no' => '1'
            ],
            [
                'brgy' => 'Brgy. 2, Santa Joaquina',
                'brgy_no' => '2'
            ],
            [
                'brgy' => 'Brgy. 3, Nuestra Señora del Rosario',
                'brgy_no' => '3'
            ],
            [
                'brgy' => 'Brgy. 4, San Guillermo',
                'brgy_no' => '4'
            ],
            [
                'brgy' => 'Brgy. 5, San Pedro',
                'brgy_no' => '5'
            ],
            [
                'brgy' => 'Brgy. 6, San Agustin',
                'brgy_no' => '6'
            ],
            [
                'brgy' => 'Brgy. 7-A, Nuestra Señora del Natividad',
                'brgy_no' => '7-A'
            ],
            [
                'brgy' => 'Brgy. 7-B, Nuestra Señora del Natividad',
                'brgy_no' => '7-B'
            ],
            [
                'brgy' => 'Brgy. 8, San Vicente',
                'brgy_no' => '8'
            ],
            [
                'brgy' => 'Brgy. 9, Santa Angela',
                'brgy_no' => '9'
            ],
            [
                'brgy' => 'Brgy. 10, San Jose',
                'brgy_no' => '10'
            ],
            [
                'brgy' => 'Brgy. 11, Santa Balbina',
                'brgy_no' => '11'
            ],
            [
                'brgy' => 'Brgy. 12, San Isidro',
                'brgy_no' => '12'
            ],
            [
                'brgy' => 'Brgy. 13, Nuestra Señora de Visitacion',
                'brgy_no' => '13'
            ],
            [
                'brgy' => 'Brgy. 14, Santo Tomas',
                'brgy_no' => '14'
            ],
            [
                'brgy' => 'Brgy. 15, San Guillermo',
                'brgy_no' => '15'
            ],
            [
                'brgy' => 'Brgy. 16, San Jacinto',
                'brgy_no' => '16'
            ],
            [
                'brgy' => 'Brgy. 17, San Francisco',
                'brgy_no' => '17'
            ],
            [
                'brgy' => 'Brgy. 18, San Quirino',
                'brgy_no' => '18'
            ],
            [
                'brgy' => 'Brgy. 19, Santa Marcela',
                'brgy_no' => '19'
            ],
            [
                'brgy' => 'Brgy. 20, San Miguel',
                'brgy_no' => '20'
            ],
            [
                'brgy' => 'Brgy. 21, San Pedro',
                'brgy_no' => '21'
            ],
            [
                'brgy' => 'Brgy. 22, San Andres',
                'brgy_no' => '22'
            ],
            [
                'brgy' => 'Brgy. 23, San Matias',
                'brgy_no' => '23'
            ],
            [
                'brgy' => 'Brgy. 24, Nuestra Señora de Consolacion',
                'brgy_no' => '24'
            ],
            [
                'brgy' => 'Brgy. 25, Santa Cayetana',
                'brgy_no' => '25'
            ],
            [
                'brgy' => 'Brgy. 26, San Marcelino',
                'brgy_no' => '26'
            ],
            [
                'brgy' => 'Brgy. 27, Nuestra Señora de Soledad',
                'brgy_no' => '27'
            ],
            [
                'brgy' => 'Brgy. 28, San Bernardo',
                'brgy_no' => '28'
            ],
            [
                'brgy' => 'Brgy. 29, Santo Tomas',
                'brgy_no' => '29'
            ],
            [
                'brgy' => 'Brgy. 30-A, Suyo',
                'brgy_no' => '30-A'
            ],
            [
                'brgy' => 'Brgy. 30-B, Santa Maria',
                'brgy_no' => '30-B'
            ],
            [
                'brgy' => 'Brgy. 31, Talingaan',
                'brgy_no' => '31'
            ],
            [
                'brgy' => 'Brgy. 32-A, La Paz East',
                'brgy_no' => '32-A'
            ],
            [
                'brgy' => 'Brgy. 32-B, La Paz West',
                'brgy_no' => '32-B'
            ],
            [
                'brgy' => 'Brgy. 32-C, La Paz East',
                'brgy_no' => '32-C'
            ],
            [
                'brgy' => 'Brgy. 33-A, La Paz Proper',
                'brgy_no' => '33-A'
            ],
            [
                'brgy' => 'Brgy. 33-B, La Paz Proper',
                'brgy_no' => '33-B'
            ],
            [
                'brgy' => 'Brgy. 34-A, Gabu Norte West',
                'brgy_no' => '34-A'
            ],
            [
                'brgy' => 'Brgy. 34-B, Gabu Norte East',
                'brgy_no' => '34-B'
            ],
            [
                'brgy' => 'Brgy. 35, Gabu Sur',
                'brgy_no' => '35'
            ],
            [
                'brgy' => 'Brgy. 36, Araniw',
                'brgy_no' => '36'
            ],
            [
                'brgy' => 'Brgy. 37, Calayab',
                'brgy_no' => '37'
            ],
            [
                'brgy' => 'Brgy. 38-A, Mangato East',
                'brgy_no' => '38-A'
            ],
            [
                'brgy' => 'Brgy. 38-B, Mangato West',
                'brgy_no' => '38-B'
            ],
            [
                'brgy' => 'Brgy. 39, Santa Rosa',
                'brgy_no' => '39'
            ],
            [
                'brgy' => 'Brgy. 40, Balatong',
                'brgy_no' => '40'
            ],
            [
                'brgy' => 'Brgy. 41, Balacad',
                'brgy_no' => '41'
            ],
            [
                'brgy' => 'Brgy. 42, Apaya',
                'brgy_no' => '42'
            ],
            [
                'brgy' => 'Brgy. 43, Cavit',
                'brgy_no' => '43'
            ],
            [
                'brgy' => 'Brgy. 44, Zamboanga',
                'brgy_no' => '44'
            ],
            [
                'brgy' => 'Brgy. 45, Tangid',
                'brgy_no' => '45'
            ],
            [
                'brgy' => 'Brgy. 46, Nalbo',
                'brgy_no' => '46'
            ],
            [
                'brgy' => 'Brgy. 47, Bengcag',
                'brgy_no' => '47'
            ],
            [
                'brgy' => 'Brgy. 48-A, Cabungaan North',
                'brgy_no' => '48-A'
            ],
            [
                'brgy' => 'Brgy. 48-B, Cabungaan South',
                'brgy_no' => '48-B'
            ],
            [
                'brgy' => 'Brgy. 49-A, Darayday',
                'brgy_no' => '49-A'
            ],
            [
                'brgy' => 'Brgy. 49-B, Raraburan',
                'brgy_no' => '49-B'
            ],
            [
                'brgy' => 'Brgy. 50, Buttong',
                'brgy_no' => '50'
            ],
            [
                'brgy' => 'Brgy. 51-A, Nangalisan East',
                'brgy_no' => '51-A'
            ],
            [
                'brgy' => 'Brgy. 51-B, Nangalisan West',
                'brgy_no' => '51-B'
            ],
            [
                'brgy' => 'Brgy. 52-A, San Mateo',
                'brgy_no' => '52-A'
            ],
            [
                'brgy' => 'Brgy. 52-B, Lataag',
                'brgy_no' => '52-B'
            ],
            [
                'brgy' => 'Brgy. 53, Rioeng',
                'brgy_no' => '53'
            ],
            [
                'brgy' => 'Brgy. 54-A, Camangaan',
                'brgy_no' => '54-A'
            ],
            [
                'brgy' => 'Brgy. 54-B, Lagui-Sail',
                'brgy_no' => '54-B'
            ],
            [
                'brgy' => 'Brgy. 55-A, Barit-Pandan',
                'brgy_no' => '55-A'
            ],
            [
                'brgy' => 'Brgy. 55-B, Salet-Bulangon',
                'brgy_no' => '55-B'
            ],
            [
                'brgy' => 'Brgy. 55-C, Vira',
                'brgy_no' => '55-C'
            ],
            [
                'brgy' => 'Brgy. 56-A, Bacsil North',
                'brgy_no' => '56-A'
            ],
            [
                'brgy' => 'Brgy. 56-B, Bacsil South',
                'brgy_no' => '56-B'
            ],
            [
                'brgy' => 'Brgy. 57, Pila',
                'brgy_no' => '57'
            ],
            [
                'brgy' => 'Brgy. 58, Casili',
                'brgy_no' => '58'
            ],
            [
                'brgy' => 'Brgy. 59-A, Dibua South',
                'brgy_no' => '59-A'
            ],
            [
                'brgy' => 'Brgy. 59-B, Dibua North',
                'brgy_no' => '59-B'
            ],
            [
                'brgy' => 'Brgy. 60-A, Caaoacan',
                'brgy_no' => '60-A'
            ],
            [
                'brgy' => 'Brgy. 60-B, Madiladig',
                'brgy_no' => '60-B'
            ],
            [
                'brgy' => 'Brgy. 61, Cataban',
                'brgy_no' => '61'
            ],
            [
                'brgy' => 'Brgy. 62-A, Navotas North',
                'brgy_no' => '62-A'
            ],
            [
                'brgy' => 'Brgy. 62-B, Navotas South',
                'brgy_no' => '62-B'
            ],
        ]);
    }
}
