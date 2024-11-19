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
        Schema::create('home_sections', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('alias');
            $table->text('description')->nullable();
            $table->integer('items_number')->nullable();
            $table->integer('cache_expiry_time')->unsigned()->nullable();
            $table->boolean('status')->default(true);
            $table->bigInteger('sort_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_sections');
    }
};
