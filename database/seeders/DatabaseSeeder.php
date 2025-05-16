<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'Test Admin',
            'last_name' => 'administrateur',
            'phone' => '675066919',
            'email' => 'admin@localhost.com',
            'user_type'=>User::ADMIN_TYPE
        ]);
        $country=new Country([
            'status'=>true,
            'name'=>'Cameroon',
            'code_iso'=>'CM',
            'code_phone'=>'237'
        ]);
        $country->save();
        $city=new City([
            'name'=>'Douala',
            'longitude'=>'9.786072',
            'latitude'=>'4.061536',
            'country_id'=>1
        ]);
        $city->save();
        $city2=new City([
            'name'=>'Yaounde',
            'longitude'=>'11.501346',
            'latitude'=>'3.844119',
            'country_id'=>1
        ]);
        $city2->save();
    }
}
