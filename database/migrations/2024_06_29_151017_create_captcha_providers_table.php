<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('captcha_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alias');
            $table->string('logo');
            $table->longText('settings');
            $table->text('instructions')->nullable();
            $table->boolean('status')->default(false)->comment('0:Disabled 1:Enabled');
            $table->boolean('is_default')->default(false)->comment('0:No 1:Yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('captcha_providers');
    }
};
