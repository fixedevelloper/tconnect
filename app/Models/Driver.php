<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string|null $driving_license_number
 * @property string|null $driving_license_from
 * @property string|null $driving_license_back
 * @property string $balance
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereDrivingLicenseBack($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereDrivingLicenseFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereDrivingLicenseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereUserId($value)
 * @mixin \Eloquent
 */
class Driver extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
