<?php


namespace App\Http\Controllers\API;


use App\Helpers\api\Helpers;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Driver;
use App\Models\Vehicule;
use Illuminate\Http\Request;

class StaticController extends Controller
{
    public function getCountries(Request $request){
        $countries=Country::query()->where(['status'=>true])->get();
        $data=[];
        foreach ($countries as $country){
            $data[]=[
                'name'=>$country['name'],
                'code_iso'=>$country['code_iso'],
                'code_phone'=>$country['code_phone'],
                'id'=>$country['id'],
                'flag'=>$country['name'],
            ];
        }
        return Helpers::success($data,'success');
    }
    public function getCities(Request $request){
        $personnal = $request->personnal;

        $countries=City::query()->where(['country_id'=>$personnal->country_id])->get();
        $data=[];
        foreach ($countries as $country){
            $data[]=[
                'name'=>$country['name'],
                'latitude'=>$country['latitude'],
                'longitude'=>$country['longitude'],
                'id'=>$country['id'],
                'country_id'=>$country['country_id'],
            ];
        }
        return Helpers::success($data,'success');
    }
    public function getVehicules(Request $request){
        $personnal = $request->personnal;
        $driver=Driver::query()->firstWhere(['user_id'=>$personnal->id]);
        $vehicules=Vehicule::query()->where(['driver_id'=>$driver->id])->get();
        $data=[];
        foreach ($vehicules as $country){
            $data[]=[
                'marque'=>$country['marque'],
                'color'=>$country['color'],
                'matriculate'=>$country['matriculate'],
                'id'=>$country['id'],
                'driver_id'=>$country['driver_id'],
            ];
        }
        return Helpers::success($data,'success');
    }
}
