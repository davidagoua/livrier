<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocaliteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('localites')->insert([
            ['name'=>'Yopougon'],
            ['name'=>'Cocody'],
            ['name'=>'Adjame'],
            ['name'=>'Koumassi'],
            ['name'=>'Marcory'],
            ['name'=>'Bingerville'],
            ['name'=>'Abobo'],
            ['name'=>'Treichville'],
            ['name'=>'Port-bouët'],
            ['name'=>'Songon'],
            ['name'=>'Plateau'],
        ]);
    }
}
