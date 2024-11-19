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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sort_id')->default(0);
            $table->string('name');
            $table->string('alias');
            $table->string('logo');
            $table->integer('fees')->default(0);
            $table->longText('credentials')->nullable();
            $table->longText('parameters')->nullable();
            $table->boolean('is_manual')->default(false);
            $table->longText('instructions')->nullable();
            $table->enum('mode', ['sandbox', 'live'])->nullable();
            $table->boolean('status')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
