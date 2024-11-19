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
        Schema::create('item_comment_reports', function (Blueprint $table) {
            $table->id()->startingValue(1000);
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('item_comment_reply_id')->unsigned();
            $table->longText('reason');
            $table->foreign("item_comment_reply_id")->references("id")->on('item_comment_replies')->onDelete('cascade');
            $table->foreign("user_id")->references("id")->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_comment_reports');
    }
};