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
        Schema::create('premium_earnings', function (Blueprint $table) {
            $table->id()->startingValue(1000);
            $table->string('name');
            $table->double('price');
            $table->text('tax')->nullable();
            $table->double('total');
            $table->bigInteger('subscription_id')->unsigned();
            $table->foreign("subscription_id")->references("id")->on('subscriptions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('premium_earnings');
    }
};
