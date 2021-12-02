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
                'arena' => 'ABA01 GALLERA DE LEGAZPI-ARENA',
                'bank_id' => '1',
                'address' => 'test',
                'operator' =>'test1',
                'contact_number' => '091234567893',
                'email' => 'test@example.com',
            ],
            [
                'arena' => 'ABA02 CAMALIG COCKPIT AND SPORTS COMPLEX INC.-ARENA',
                'bank_id' => '2',
                'address' => 'test',
                'operator' =>'test1',
                'contact_number' => '091234567893',
                'email' => 'test@example.com',
            ],
            [
                'arena' => 'ABA04 CAGSAWA COCKPIT ARENA-ARENA',
                'bank_id' => '1',
                'address' => 'test',
                'operator' =>'test1',
                'contact_number' => '091234567893',
                'email' => 'test@example.com',
            ],
            [
                'arena' => 'ABA05 HOMAPON COCKPIT-ARENA',
                'bank_id' => '3',
                'address' => 'test',
                'operator' =>'test1',
                'contact_number' => '091234567893',
                'email' => 'test@example.com',
            ],
            [
                'arena' => 'AKA01 GARCIA RECREATION SPORTS COCKPIT CENTER (TIGAYON KALIBO COCKPIT ARENA)-ARENA',
                'bank_id' => '2',
                'address' => 'test',
                'operator' =>'test1',
                'contact_number' => '091234567893',
                'email' => 'test@example.com',
            ],
            [
                'arena' => 'AKA02 ISLANDERS SPORTS AND AMUSEMENT CORP. (BORACAY COCKPIT ARENA)-ARENA',
                'bank_id' => '1',
                'address' => 'test',
                'operator' =>'test1',
                'contact_number' => '091234567893',
                'email' => 'test@example.com',
            ],
            [
                'arena' => 'ARMSI/L8SQI OFFICE-ARENA',
                'bank_id' => '1',
                'address' => 'test',
                'operator' =>'test1',
                'contact_number' => '091234567893',
                'email' => 'test@example.com',
            ],
            [
                'arena' => "ASA01 KEMJAY'S BETTING STATION (BAYUGAN COCKER'S MULTIPURPOSE COOPERATIVE)-ARENA",
                'bank_id' => '2',
                'address' => 'test',
                'operator' =>'test1',
                'contact_number' => '091234567893',
                'email' => 'test@example.com',
            ],
            [
                'arena' => 'BTA01 LEMERY COCKPIT ARENA-ARENA',
                'bank_id' => '1',
                'address' => 'test',
                'operator' =>'test1',
                'contact_number' => '091234567893',
                'email' => 'test@example.com',
            ],
            [
                'arena' => 'BTA02 SAN PASCUAL MINI COCKPIT-ARENA',
                'bank_id' => '2',
                'address' => 'test',
                'operator' =>'test1',
                'contact_number' => '091234567893',
                'email' => 'test@example.com',
            ]
        ]);
    }
}
