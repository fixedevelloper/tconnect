<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string|null $model
 * @property string|null $color
 * @property string|null $marque
 * @property string|null $matriculate
 * @property int|null $driver_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicule query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicule whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicule whereDriverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicule whereMarque($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicule whereMatriculate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicule whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Vehicule extends Model
{
    protected $fillable = [
        'marque',
        'color',
        'model',
        'matriculate',
        'driver_id',
    ];
}
