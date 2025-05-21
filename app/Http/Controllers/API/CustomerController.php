<?php


namespace App\Http\Controllers\API;


use App\Helpers\api\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Passager;
use App\Models\Reservation;
use App\Models\Trajet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function searchTrajets(Request $request)
    {
        $personnal = $request->personnal;
        $city_to = $request->city_to;
        $city_from = $request->city_from;
        $date_from = $request->date_from;
        $place = $request->place;
        if ($request->has('other')) {
            $trajets = Trajet::query()->where(['city_to_id' => $city_to, 'city_from_id' => $city_from])
                ->whereDate('date_from', '>=', $date_from)->get();
        } else {
            $trajets = Trajet::query()->where(['city_to_id' => $city_to, 'city_from_id' => $city_from, 'date_from' => $date_from])
                ->where('place_rest', '>=', $place)->get();
        }


        $data = [];
        foreach ($trajets as $trajet) {
            //$reservationplace=Reservation::query()->where(['trajet_id'=>$trajet->id])->sum('place');
            //if ($reservationplace+$place<=$trajet->place){
            $data[] = [
                'id' => $trajet->id,
                'price' => $trajet->price,
                'place' => $trajet->place,
                'place_rest' => $trajet->place_rest,
                'date_from' => $trajet->date_from,
                'date_to' => $trajet->date_to,
                'time_from' => $trajet->time_from,
                'city_from_id' => $trajet->city_from->id,
                'city_from_name' => $trajet->city_from->name,
                'city_to_id' => $trajet->city_to->id,
                'city_to_name' => $trajet->city_to->name,
                'city_to_lat' => $trajet->city_to->latitude,
                'city_to_long' => $trajet->city_to->longitude,
                'city_from_lat' => $trajet->city_from->latitude,
                'city_from_long' => $trajet->city_from->longitude,
                'driver_id' => $trajet->driver_id,
                'quarter_to' => $trajet->quarter_to,
                'quarter_from' => $trajet->quarter_from,
                'vehicule_id' => $trajet->vehicule_id,
                'vehicule_marque' => $trajet->vehicule->marque,
                'vehicule_color' => $trajet->vehicule->color,
                'vehicule_matricalte' => $trajet->vehicule->matriculate,
                'time_to' => $trajet->time_to,
                'driver_name' => $trajet->driver->user->first_name . '' . $trajet->driver->user->last_name
            ];
            // }

        }
        return Helpers::success($data, 'success');
    }

    public function saveReservation(Request $request)
    {
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
        $passager = Passager::firstWhere(['user_id' => $personnal->id]);
        $trajet = Trajet::find($request->trajet_id);
        if ($trajet->place_rest < $request->place) {
            return Helpers::error('Place indisponible');
        }
        DB::beginTransaction();
        $reservation = new Reservation();
        $reservation->trajet_id = $trajet->id;
        $reservation->passager_id = $passager->id;
        $reservation->place = $request->place;
        $reservation->amount = $request->place * $trajet->price;
        $reservation->method_payment = $request->method_payment;
        $reservation->save();
        $trajet->place_rest -= $reservation->place;
        $trajet->save();
        DB::commit();
        return Helpers::success($reservation, 'success');
    }

    public function getReservations(Request $request)
    {
        $personnal = $request->personnal;
        $passager = Passager::firstWhere(['user_id' => $personnal->id]);
        $reservations = Reservation::query()->where(['passager_id' => $passager->id])->get();
        $data = [];
        foreach ($reservations as $reservation) {
            $data[] = [
                'id' => $reservation->id,
                'place' => $reservation->place,
                'amount' => $reservation->amount,
                'method_payment' => $reservation->method_payment,
                'status' => $reservation->stringStatus->value,
                'date_from' => $reservation->trajet->date_from,
                'date_to' => $reservation->trajet->date_to,
                'time_from' => $reservation->trajet->time_from,
                'city_from_id' => $reservation->trajet->city_from->id,
                'city_from_name' => $reservation->trajet->city_from->name,
                'city_to_id' => $reservation->trajet->city_to->id,
                'city_to_name' => $reservation->trajet->city_to->name,
                'city_to_lat' => $reservation->trajet->city_to->latitude,
                'city_to_long' => $reservation->trajet->city_to->longitude,
                'city_from_lat' => $reservation->trajet->city_from->latitude,
                'city_from_long' => $reservation->trajet->city_from->longitude,
                'quarter_to' => $reservation->trajet->quarter_to,
                'quarter_from' => $reservation->trajet->quarter_from,
                'vehicule_id' => $reservation->trajet->vehicule_id,
                'vehicule_marque' => $reservation->trajet->vehicule->marque,
                'vehicule_color' => $reservation->trajet->vehicule->color,
                'vehicule_matricalte' => $reservation->trajet->vehicule->matriculate,
                'time_to' => $reservation->trajet->time_to,
                'driver_id' =>$reservation->trajet->driver_id,
                'driver_name' => $reservation->trajet->driver->user->first_name . '' . $reservation->trajet->driver->user->last_name,
                'passager_id' =>$reservation->passager->id,
                'passager_first_name' =>$reservation->passager->user->first_name,
                'passager_last_name' =>$reservation->passager->user->last_name,
                'passager_photo' =>$reservation->passager->user->photo,
            ];
        }
        return Helpers::success($data, 'success');
    }
}
