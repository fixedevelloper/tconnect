<?php


namespace App\Http\Controllers\API;


use App\Helpers\api\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Passager;
use App\Models\Reservation;
use App\Models\Trajet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function searchTrajets(Request $request){
        $personnal = $request->personnal;
        $city_to=$request->city_to;
        $city_from=$request->city_from;
        $date_from=$request->date_from;
        logger($date_from);
        $place=$request->place;
        $trajets=Trajet::query()->where(['city_to_id'=>$city_to,'city_from_id'=>$city_from,'date_from'=>$date_from])->get();
        $data=[];
        foreach ($trajets as $trajet){
            $data[]=[
                'id'=>$trajet->id,
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
                'driver_name' =>  $trajet->driver->user->first_name. ''.$trajet->driver->user->last_name
            ];
        }
        return Helpers::success($data,'success');
    }
    public function saveReservation(Request $request){
        $personnal = $request->personnal;
        $validator = Validator::make($request->all(), [
            'place' => 'required',
            'method_payment' => 'required',
            'trajet_id' => 'required',
        ]);

        if ($validator->fails()) {
            $err = null;
            foreach ($validator->errors()->all() as $error) {
                $err = $error;
            }
            return Helpers::error($err);
        }
        $passager=Passager::firstWhere(['user_id'=>$personnal->id]);
        $trajet=Trajet::find($request->trajet_id);
        if ($trajet->place_rest<$request->place){
            return Helpers::error('Place indisponible');
        }
        $reservation=new Reservation();
        $reservation->trajet_id=$trajet->id;
        $reservation->passager_id=$passager->id;
        $reservation->place=$request->place;
        $reservation->amount=$request->place*$trajet->price;
        $reservation->method_payment=$request->method_payment;
        $reservation->save();
        return Helpers::success($reservation,'success');
    }
}
