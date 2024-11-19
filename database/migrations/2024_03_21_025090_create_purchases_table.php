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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id()->startingValue(1000);
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('sale_id')->unsigned();
            $table->bigInteger('item_id')->unsigned();
            $table->tinyInteger('license_type')->comment('1:Regular 2:Extended');
            $table->string('code')->unique();
            $table->dateTime('support_expiry_at')->nullable();
            $table->boolean('is_downloaded')->default(false);
            $table->tinyInteger('status')->default(1)->comment('1:Active 2:Refunded 3:Cancelled');
            $table->foreign("user_id")->references("id")->on('users')->onDelete('cascade');
            $table->foreign("sale_id")->references("id")->on('sales')->onDelete('cascade');
            $table->foreign("item_id")->references("id")->on('items')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};