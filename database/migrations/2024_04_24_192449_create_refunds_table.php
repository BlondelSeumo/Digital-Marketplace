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
        Schema::create('refunds', function (Blueprint $table) {
            $table->id()->startingValue(1000);
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('purchase_id')->unsigned();
            $table->tinyInteger('status')->default(1)->comment('1:Pending 2:Accepted 3:Declined');
            $table->foreign("user_id")->references("id")->on('users')->onDelete('cascade');
            $table->foreign("purchase_id")->references("id")->on('purchases')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};