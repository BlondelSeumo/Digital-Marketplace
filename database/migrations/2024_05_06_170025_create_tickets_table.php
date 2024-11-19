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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id()->startingValue(1000);
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('ticket_category_id')->unsigned();
            $table->string('subject');
            $table->tinyInteger('status')->default(1)->comment('1:Opened 2:Closed');
            $table->foreign("ticket_category_id")->references("id")->on('ticket_categories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
