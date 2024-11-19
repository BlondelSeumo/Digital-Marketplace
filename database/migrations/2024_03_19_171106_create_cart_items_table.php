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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('session_id')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('item_id')->unsigned();
            $table->tinyInteger('license_type')->default(1)->comment('1:Regular 2:Extended');
            $table->integer('quantity')->unsigned()->default(1);
            $table->bigInteger('support_period_id')->unsigned()->nullable();
            $table->foreign("item_id")->references("id")->on('items')->onDelete('cascade');
            $table->foreign("user_id")->references("id")->on('users')->onDelete('cascade');
            $table->foreign("support_period_id")->references("id")->on('support_periods')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};