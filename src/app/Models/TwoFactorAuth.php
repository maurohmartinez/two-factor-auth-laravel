<?php

namespace MHMartinez\TwoFactorAuth\app\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AlertAdmin
 *
 * @property int $id
 * @property int $user_id
 * @property string $secret
 */
class TwoFactorAuth extends Model
{
    protected $table = 'two_factor_auth';
    protected $fillable = ['user_id', 'secret'];

    public function getSecretAttribute(string $value)
    {
        return $this->attributes['secret'] = decrypt($value);
    }

    public function setSecretAttribute(string $value)
    {
        $this->attributes['secret'] = encrypt($value);
    }
}