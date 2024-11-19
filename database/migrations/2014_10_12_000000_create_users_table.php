<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname', 50)->nullable();
            $table->string('lastname', 50)->nullable();
            $table->string('username', 50)->unique()->nullable();
            $table->string('email', 100)->unique()->nullable();
            $table->text('address')->nullable();
            $table->string('password')->nullable();
            $table->double('balance')->default(0);
            $table->string('avatar')->nullable();
            $table->string('facebook_id')->unique()->nullable();
            $table->string('google_id')->unique()->nullable();
            $table->string('microsoft_id')->unique()->nullable();
            $table->string('vkontakte_id')->unique()->nullable();
            $table->string('envato_id')->unique()->nullable();
            $table->string('github_id')->unique()->nullable();
            $table->boolean('is_admin')->default(false);
            $table->boolean('was_subscribed')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('kyc_status')->default(false);
            $table->boolean('google2fa_status')->default(false)->comment('0: Disabled, 1: Active');
            $table->text('google2fa_secret')->nullable();
            $table->boolean('status')->default(true)->comment('0: Banned, 1: Active');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
