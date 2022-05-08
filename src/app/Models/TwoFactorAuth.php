<?php

namespace MHMartinez\TwoFactorAuth\app\Models;

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

    public function getSecretAttribute(string $value): ?string
    {
        return $this->attributes['secret'] = $value ? decrypt($value) : null;
    }

    public function setSecretAttribute(string $value): void
    {
        $this->attributes['secret'] = encrypt($value);
    }
}