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
        Schema::create('two_factor_auth', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->text('secret')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('two_factor_auth');
    }
};
