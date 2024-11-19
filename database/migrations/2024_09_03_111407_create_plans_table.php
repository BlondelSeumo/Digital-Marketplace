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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('interval', ['week', 'month', 'year', 'lifetime']);
            $table->double('price')->nullable();
            $table->bigInteger('downloads')->unsigned()->nullable();
            $table->longText('custom_features')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('featured')->default(false);
            $table->bigInteger('sort_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
