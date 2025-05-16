<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $balance
 * @property string|null $preference
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Passager newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Passager newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Passager query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Passager whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Passager whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Passager whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Passager wherePreference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Passager whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Passager whereUserId($value)
 * @mixin \Eloquent
 */
class Passager extends Model
{
    protected $fillable=[
      'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
