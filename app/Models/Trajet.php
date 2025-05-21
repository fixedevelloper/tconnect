<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property string $price
 * @property int $place
 * @property string $date_from
 * @property string $date_to
 * @property string $time_from
 * @property string $time_to
 * @property string|null $quarter_to
 * @property string|null $quarter_from
 * @property int $status
 * @property int|null $city_from_id
 * @property int|null $city_to_id
 * @property int|null $driver_id
 * @property int|null $vehicule_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\City|null $city_from
 * @property-read \App\Models\City|null $city_to
 * @property-read \App\Models\Driver|null $driver
 * @property-read \App\Models\Vehicule|null $vehicule
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trajet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trajet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trajet query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trajet whereCityFromId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trajet whereCityToId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trajet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trajet whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trajet whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trajet whereDriverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trajet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trajet wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trajet wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trajet whereQuarterFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trajet whereQuarterTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trajet whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trajet whereTimeFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trajet whereTimeTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trajet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trajet whereVehiculeId($value)
 * @mixin \Eloquent
 */
class Trajet extends Model
{
    protected $fillable=[
        'price',
        'place',
        'date_from',
        'date_to',
        'time_from',
        'city_from_id',
        'city_to_id',
        'quarter_to',
        'quarter_from',
        'vehicule_id',
        'time_to',
        'driver_id'
    ];
    public function city_from()
    {
        return $this->belongsTo(City::class,'city_from_id','id');
    }
    public function city_to()
    {
        return $this->belongsTo(City::class,'city_to_id','id');
    }
    public function driver()
    {
        return $this->belongsTo(Driver::class,'driver_id','id');
    }
    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class,'vehicule_id','id');
    }
    public function getStringStatusAttribute() {
        $status = $this->status;
        $data = [
            'class' => "",
            'value' => "",
        ];
        if($status == Helper::STATUSSUCCESS) {
            $data = [
                'class'     => "badge rounded-pill bg-success",
                'value'     => "accepted",
            ];
        }else if($status == Helper::STATUSPENDING) {
            $data = [
                'class'     => "badge rounded-pill bg-warning",
                'value'     => "Pending",
            ];
        }else if($status == Helper::STATUSHOLD) {
            $data = [
                'class'     => "badge rounded-pill bg-danger",
                'value'     => "Hold",
            ];
        }else if($status == Helper::STATUSREJECTED) {
            $data = [
                'class'     => "badge rounded-pill bg-danger",
                'value'     => "Rejected",
            ];
        }else if($status == Helper::STATUSWAITING) {
            $data = [
                'class'     => "badge rounded-pill bg-warning",
                'value'     => "Waiting",
            ];
        }else if($status == Helper::STATUSFAILD) {
            $data = [
                'class'     => "badge rounded-pill bg-danger",
                'value'     => "Failed",
            ];
        }else if($status == Helper::STATUSPROCESSING) {
            $data = [
                'class'     => "badge rounded-pill bg-warning",
                'value'     => "Processing",
            ];
        }

        return (object) $data;
    }
}
