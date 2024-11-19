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
        Schema::create('item_discounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('item_id')->unsigned();
            $table->integer('regular_percentage')->unsigned();
            $table->double('regular_price');
            $table->integer('extended_percentage')->unsigned()->nullable();
            $table->double('extended_price')->nullable();
            $table->date('starting_at');
            $table->date('ending_at');
            $table->boolean('status')->default(false);
            $table->foreign("item_id")->references("id")->on('items')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_discounts');
    }
};
