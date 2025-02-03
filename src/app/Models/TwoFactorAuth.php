<?php

namespace MHMartinez\TwoFactorAuth\app\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * App\Models\AlertAdmin
 *
 * @property int $id
 * @property int $user_id
 * @property string $secret
 */
class TwoFactorAuth extends Model
{
    use Notifiable;

    public string $email;

    protected $table = 'two_factor_auth';

    protected $fillable = ['user_id', 'secret'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('two_factor_auth.user_model'));
    }
}
