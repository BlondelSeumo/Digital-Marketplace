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
        Schema::create('support_earnings', function (Blueprint $table) {
            $table->id()->startingValue(1000);
            $table->string('name');
            $table->string('title');
            $table->bigInteger('days')->unsigned();
            $table->double('price');
            $table->text('tax')->nullable();
            $table->double('total');
            $table->tinyInteger('status')->default(1)->comment('1:Active 2:Refunded 3:Cancelled');
            $table->dateTime('support_expiry_at');
            $table->bigInteger('purchase_id')->unsigned();
            $table->foreign("purchase_id")->references("id")->on('purchases')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_earnings');
    }
};
