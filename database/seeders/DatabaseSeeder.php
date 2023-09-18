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
            ['office_name' => 'CMO - Permits & Licenses Division'],
            ['office_name' => 'City Health Office'],
            ['office_name' => 'City Treasurer Office'],
            ['office_name' => 'City Engineering Office'],
            ['office_name' => 'Bureau of Fire Protection'],
            ['office_name' => 'Information and Communications Technology Office']
        ]);
        
        $pld = Office::where('office_name', 'CMO - Permits & Licenses Division')->first();
        $cho = Office::where('office_name', 'City Health Office')->first();
        $cto = Office::where('office_name', 'City Treasurer Office')->first();
        $ceo = Office::where('office_name', 'City Engineering Office')->first();
        $bfp = Office::where('office_name', 'Bureau of Fire Protection')->first();
        $icto = Office::where('office_name', 'Information and Communications Technology Office')->first();
        
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

        DB::table('')->insert([
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
            ['brgy' => 'Brgy. 1, San Lorenzo'],
            ['brgy' => 'Brgy. 2, Santa Joaquina'],
            ['brgy' => 'Brgy. 3, Nuestra Señora del Rosario'],
            ['brgy' => 'Brgy. 4, San Guillermo'],
            ['brgy' => 'Brgy. 5, San Pedro'],
            ['brgy' => 'Brgy. 6, San Agustin'],
            ['brgy' => 'Brgy. 7-A, Nuestra Señora del Natividad'],
            ['brgy' => 'Brgy. 7-B, Nuestra Señora del Natividad'],
            ['brgy' => 'Brgy. 8, San Vicente'],
            ['brgy' => 'Brgy. 9, Santa Angela'],
            ['brgy' => 'Brgy. 10, San Jose'],
            ['brgy' => 'Brgy. 11, Santa Balbina'],
            ['brgy' => 'Brgy. 12, San Isidro'],
            ['brgy' => 'Brgy. 13, Nuestra Señora de Visitacion'],
            ['brgy' => 'Brgy. 14, Santo Tomas'],
            ['brgy' => 'Brgy. 15, San Guillermo'],
            ['brgy' => 'Brgy. 16, San Jacinto'],
            ['brgy' => 'Brgy. 17, San Francisco'],
            ['brgy' => 'Brgy. 18, San Quirino'],
            ['brgy' => 'Brgy. 19, Santa Marcela'],
            ['brgy' => 'Brgy. 20, San Miguel'],
            ['brgy' => 'Brgy. 21, San Pedro'],
            ['brgy' => 'Brgy. 22, San Andres'],
            ['brgy' => 'Brgy. 23, San Matias'],
            ['brgy' => 'Brgy. 24, Nuestra Señora de Consolacion'],
            ['brgy' => 'Brgy. 25, Santa Cayetana'],
            ['brgy' => 'Brgy. 26, San Marcelino'],
            ['brgy' => 'Brgy. 27, Nuestra Señora de Soledad'],
            ['brgy' => 'Brgy. 28, San Bernardo'],
            ['brgy' => 'Brgy. 29, Santo Tomas'],
            ['brgy' => 'Brgy. 30-A, Suyo'],
            ['brgy' => 'Brgy. 30-B, Santa Maria'],
            ['brgy' => 'Brgy. 31, Talingaan'],
            ['brgy' => 'Brgy. 32-A, La Paz East'],
            ['brgy' => 'Brgy. 32-B, La Paz West'],
            ['brgy' => 'Brgy. 32-C, La Paz East'],
            ['brgy' => 'Brgy. 33-A, La Paz Proper'],
            ['brgy' => 'Brgy. 33-B, La Paz Proper'],
            ['brgy' => 'Brgy. 34-A, Gabu Norte West'],
            ['brgy' => 'Brgy. 34-B, Gabu Norte East'],
            ['brgy' => 'Brgy. 35, Gabu Sur'],
            ['brgy' => 'Brgy. 36, Araniw'],
            ['brgy' => 'Brgy. 37, Calayab'],
            ['brgy' => 'Brgy. 38-A, Mangato East'],
            ['brgy' => 'Brgy. 38-B, Mangato West'],
            ['brgy' => 'Brgy. 39, Santa Rosa'],
            ['brgy' => 'Brgy. 40, Balatong'],
            ['brgy' => 'Brgy. 41, Balacad'],
            ['brgy' => 'Brgy. 42, Apaya'],
            ['brgy' => 'Brgy. 43, Cavit'],
            ['brgy' => 'Brgy. 44, Zamboanga'],
            ['brgy' => 'Brgy. 45, Tangid'],
            ['brgy' => 'Brgy. 46, Nalbo'],
            ['brgy' => 'Brgy. 47, Bengcag'],
            ['brgy' => 'Brgy. 48-A, Cabungaan North'],
            ['brgy' => 'Brgy. 48-B, Cabungaan South'],
            ['brgy' => 'Brgy. 49-A, Darayday'],
            ['brgy' => 'Brgy. 49-B, Raraburan'],
            ['brgy' => 'Brgy. 50, Buttong'],
            ['brgy' => 'Brgy. 51-A, Nangalisan East'],
            ['brgy' => 'Brgy. 51-B, Nangalisan West'],
            ['brgy' => 'Brgy. 52-A, San Mateo'],
            ['brgy' => 'Brgy. 52-B, Lataag'],
            ['brgy' => 'Brgy. 53, Rioeng'],
            ['brgy' => 'Brgy. 54-A, Camangaan'],
            ['brgy' => 'Brgy. 54-B, Lagui-Sail'],
            ['brgy' => 'Brgy. 55-A, Barit-Pandan'],
            ['brgy' => 'Brgy. 55-B, Salet-Bulangon'],
            ['brgy' => 'Brgy. 55-C, Vira'],
            ['brgy' => 'Brgy. 56-A, Bacsil North'],
            ['brgy' => 'Brgy. 56-B, Bacsil South'],
            ['brgy' => 'Brgy. 57, Pila'],
            ['brgy' => 'Brgy. 58, Casili'],
            ['brgy' => 'Brgy. 59-A, Dibua South'],
            ['brgy' => 'Brgy. 59-B, Dibua North'],
            ['brgy' => 'Brgy. 60-A, Caaoacan'],
            ['brgy' => 'Brgy. 60-B, Madiladig'],
            ['brgy' => 'Brgy. 61, Cataban'],
            ['brgy' => 'Brgy. 62-A, Navotas North'],
            ['brgy' => 'Brgy. 62-B, Navotas South'],
        ]);
    }
}
