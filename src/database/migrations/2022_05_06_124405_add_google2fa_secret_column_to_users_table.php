<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use MHMartinez\TwoFactorAuth\services\TwoFactorAuthService;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config(TwoFactorAuthService::CONFIG_KEY . '.users_table'), function (Blueprint $table) {
            $table->text(config('google2fa.otp_secret_column'))->nullable()->after('password');
            $table->boolean(config(TwoFactorAuthService::CONFIG_KEY . '.is_enabled'))->default(false)->after(config('google2fa.otp_secret_column'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config(TwoFactorAuthService::CONFIG_KEY . '.users_table'), function (Blueprint $table) {
            $table->dropColumn(config('google2fa.otp_secret_column'));
            $table->dropColumn(config(TwoFactorAuthService::CONFIG_KEY . '.is_enabled'));
        });
    }
};
