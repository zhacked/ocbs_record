<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class arenaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('arenas')->insert([
            [
                'arena' => 'AB27 3GRA Betting Station (Burabod Malinao)-OCBS',
          
                'address' => 'BURADO MALINAO, ALBAY',
                'operator' =>'ANGEL FAYE DATUN',
                'contact_number' => 'xxxxxxxxxx',
                'area_code' => 'AB27'
                
            ],
            [
                'arena' => 'AB23 3R Betting Station (Brgy. 3 Malilipot)-OCBS',
                
                'address' => 'BRGY.3 POBLACION MALILIPOT ALBAY',
                'operator' =>'ANGEL FAYE DATUN',
                'contact_number' => 'xxxxxxxxxx',
                'area_code' => 'AB23'
            ],
            [
                'arena' => "CN01 3'S Betting Station (Camambugan Daet)-OCBS",
            
                'address' => 'PUROK 1 DIVERSION ROAD YAO, BLDG. CAMAMBUGAN, DAET CAMARINES NORTE',
                'operator' =>'SHERWIN BORJA',
                'contact_number' => 'xxxxxxxxxx',
                'area_code' => 'CN01'
            ],
            [
                'arena' => 'LG62 4 Monkeys Resto Bar (Turbina Calamba City)-OCBS-RESTOBAR',
                
                'address' => '02 KM 52 NAT\'L HIWAY, TURBINA CALAMBA CITY LAGUNA',
                'operator' =>'ANDREW TORRES',
                'contact_number' => 'xxxxxxxxxx',
                'area_code' => 'LG62'
            ],
            [
                'arena' => 'DS10 5 Sides Online Gaming Place (San Miguel Digos City)-OCBS',
             
                'address' => 'LUNA EXT. BRGY. SAN MIGUEL DIGOS CITY',
                'operator' =>'JANJAN/ROBERTSON',
                'contact_number' => 'xxxxxxxxxx',
                'area_code' => 'DS10'
            ],
            [
                'arena' => 'IS22 5A Online Gaming Place (Poblacion San Pablo)-OCBS',
                'address' => 'SAN PABLO ISABELA',
                'operator' =>'MARIO A. LAUAN',
                'contact_number' => 'xxxxxxxxxx',
                'area_code' => 'IS22'
            ],
            [
                'arena' => 'BU34 6 Stars OCBS Betting Station (Turo Bocaue)-OCBS',
                'address' => '#1188 GIV.F. HALILI AVE., TURO, BOCAUE, BULACAN',
                'operator' =>'ALBERT / RAYNAN TALA',
                'contact_number' => 'xxxxxxxxxx',
                'area_code' => 'BU34'
            ],
            [
                'arena' => 'ORM11 777 JRL Betting Station (Brgy. Poblacion Baco)-OCBS',
                'address' => 'BRGY. POBLACION BACO ORIENTAL MINDORO',
                'operator' =>'LIMUEL PAMINTUAN',
                'contact_number' => 'xxxxxxxxxx',
                'area_code' => 'ORM11'
            ],
            [
                'arena' => 'CV05 AADR Resto Bar & Online & Streaming (Bucal Tanza)-OCBS-RESTOBAR',
                'address' => 'A SORIANO ST.A+A PARADE BUILDING BUCAL TANZA',
                'operator' =>'ANTONIO DEL ROSARIO',
                'contact_number' => 'xxxxxxxxxx',
                'area_code' => 'CV05'
            ],
            [
                'arena' => 'IS41 AAJ Breed Online Gaming Place (San Antonino Burgos)-OCBS',
                'address' => 'SAN ANTONIO, BURGOS, ISABELA',
                'operator' =>'ALFREDO DALUPANG TAGUBA JR.',
                'contact_number' => 'xxxxxxxxxx',
                'area_code' => 'IS41'
            ],
          
            [
                'arena' => 'IS27 AAJ Farmers Online Gaming Place (Patul Santiago City)-OCBS',
                'address' => 'PUROK 5 BRGY. PATOL SANTIAGO CITY ISABELA',
                'operator' =>'ACE CASTRO',
                'contact_number' => 'xxxxxxxxxx',
                'area_code' => 'IS27'
            ],
            [
                'arena' => 'MA09 AH Mariano (Tondo)-OCBS-OTB',
                'address' => '1211 QUIRICADA ST. TONDO 023 BRGY.253, MANILA',
                'operator' =>'ARMANDO MARIANO',
                'contact_number' => 'xxxxxxxxxx',
                'area_code' => 'MA09'
                
            ],
            [
                'arena' => 'MA14 AKC Billiard OTB (Tondo)-OCBS-OTB',
                'address' => '360 DEL PIERRO GAGALANGIN, TONDO, MANILA',
                'operator' =>'JOEY CALDERON',
                'contact_number' => 'xxxxxxxxxx',
                'area_code' => 'MA14'
            ],
         
        ]);
    }
}
