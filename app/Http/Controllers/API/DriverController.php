<?php


namespace App\Http\Controllers\API;


use App\Helpers\api\Helpers;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Driver;
use App\Models\Trajet;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    public function createDriver(Request $request){
        $personnal = $request->personnal;
        $validator = Validator::make($request->all(), [
/*            'driving_license_number' => 'required',
            'driving_license_from' => 'required',
            'driving_license_back' => 'required',*/
            'marque' => 'required',
            'color' => 'required',
            'matriculate' => 'required'
        ]);

        if ($validator->fails()) {
            $err = null;
            foreach ($validator->errors()->all() as $error) {
                $err = $error;
            }
            return Helpers::error($err);
        }

        DB::beginTransaction();
        $driver=new Driver();
        $driver->user_id=$personnal->id;
        $driver->save();
        $body=[
            'model' => $request->model,
            'marque' => $request->marque,
            'color' =>  $request->color,
            'matriculate' =>  $request->matriculate,
            'driver_id'=>$driver->id
        ];
        $car=new Vehicule($body);
        $car->save($body);
        DB::commit();
        return Helpers::success([
            'first_name'=>$driver->user->first_name,
            'last_name'=>$driver->user->last_name,
            'email'=>$driver->user->email,
            'phone'=>$driver->user->phone,
            'country_name'=>$driver->user->country->name,
            'country_id'=>$driver->user->country->id,
            'balance'=>$driver->balance,

        ]);
    }

    public function createTrajet(Request $request){
        $personnal = $request->personnal;
        $validator = Validator::make($request->all(), [
            'price' => 'required',
            'place' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
            'time_from' => 'required',
            'time_to' => 'required',
            'city_from_id' => 'required',
            'city_to_id' => 'required',
            'quarter_to' => 'required',
            'quarter_from' => 'required',
            'vehicule_id' => 'required'
        ]);

        if ($validator->fails()) {
            $err = null;
            foreach ($validator->errors()->all() as $error) {
                $err = $error;
            }
            return Helpers::error($err);
        }
        $driver=Driver::query()->firstWhere('user_id',$personnal->id);
        $body=[
            'price' => $request->price,
            'place' =>  $request->place,
            'date_from' =>  $request->date_from,
            'date_to' =>  $request->date_to,
            'time_from' =>  $request->time_from,
            'city_from_id' =>  $request->city_from_id,
            'city_to_id' =>  $request->city_to_id,
            'quarter_to' =>  $request->quarter_to,
            'quarter_from' =>  $request->quarter_from,
            'vehicule_id' =>  $request->vehicule_id,
            'time_to' =>  $request->time_to,
            'driver_id' =>  $driver->id,

        ];
        $trajet=Trajet::query()->firstWhere(['date_from'=>$request->date_from,'time_from'=>$request->time_from,'driver_id'=>$driver->id]);
        if (!is_null($trajet)){
            return Helpers::error('Trajet deja enregistre');
        }
        try {
            $trajet=new Trajet($body);
            $trajet->save($body);
            return Helpers::success([
                'price'=>$trajet->price,
                'place'=>$trajet->place,
                'date_from'=>$trajet->date_from,
                'time_from'=>$trajet->time_from,
                'city_from_id'=>$trajet->city_from->id,
                'city_from_name'=>$trajet->city_from->name,
                'city_to_id'=>$trajet->city_to->id,
                'city_to_name'=>$trajet->city_to->name,
            ]);
        }catch (\Exception $exception){
            return Helpers::error($exception->getMessage());
        }

    }

    public function getTrajets(Request $request){
        $personnal = $request->personnal;
        $driver=Driver::query()->firstWhere(['user_id'=>$personnal->id]);
        $trajets=Trajet::query()->where(['driver_id'=>$driver->id])->get();
        $data=[];
        foreach ($trajets as $trajet){
            $data[]=[
                'price'=>$trajet->price,
                'place'=>$trajet->place,
                'date_from'=>$trajet->date_from,
                'date_to'=>$trajet->date_to,
                'time_from'=>$trajet->time_from,
                'city_from_id'=>$trajet->city_from->id,
                'city_from_name'=>$trajet->city_from->name,
                'city_to_id'=>$trajet->city_to->id,
                'city_to_name'=>$trajet->city_to->name,
                'city_to_lat'=>$trajet->city_to->latitude,
                'city_to_long'=>$trajet->city_to->longitude,
                'city_from_lat'=>$trajet->city_from->latitude,
                'city_from_long'=>$trajet->city_from->longitude,
                'driver_id'=>$trajet->driver_id,
                'quarter_to' =>  $trajet->quarter_to,
                'quarter_from' =>  $trajet->quarter_from,
                'vehicule_id' =>  $trajet->vehicule_id,
                'vehicule_marque' =>  $trajet->vehicule->marque,
                'vehicule_color' =>  $trajet->vehicule->color,
                'vehicule_matricalte' =>  $trajet->vehicule->matriculate,
                'time_to' =>  $trajet->time_to,
                'driver_name' =>  $driver->user->first_name. ''.$driver->user->last_name
            ];
        }
        return Helpers::success($data,'success');
    }
}
