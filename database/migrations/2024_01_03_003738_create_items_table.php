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
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id')->startingValue(1000);
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->longText('description');
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('sub_category_id')->unsigned()->nullable();
            $table->longText('options')->nullable();
            $table->string('version')->nullable();
            $table->enum('demo_type', ['embed', 'direct'])->nullable();
            $table->text('demo_link')->nullable();
            $table->longText('tags');
            $table->string('thumbnail')->nullable();
            $table->enum('preview_type', ['image', 'video', 'audio'])->default('image');
            $table->string('preview_image')->nullable();
            $table->string('preview_video')->nullable();
            $table->string('preview_audio')->nullable();
            $table->string('main_file');
            $table->enum('main_file_source', ['upload', 'external'])->default('upload');
            $table->longText('screenshots')->nullable();
            $table->double('regular_price')->nullable();
            $table->double('extended_price')->nullable();
            $table->boolean('is_supported')->default(0);
            $table->text('support_instructions')->nullable();
            $table->tinyInteger('purchase_method')->default(1);
            $table->text('purchase_url')->nullable();
            $table->bigInteger('total_sales')->default(0)->unsigned();
            $table->double('total_sales_amount')->default(0);
            $table->bigInteger('total_reviews')->default(0)->unsigned();
            $table->bigInteger('avg_reviews')->default(0)->unsigned();
            $table->bigInteger('total_comments')->default(0)->unsigned();
            $table->bigInteger('total_views')->default(0)->unsigned();
            $table->bigInteger('current_month_views')->default(0)->unsigned();
            $table->bigInteger('free_downloads')->default(0)->unsigned();
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_free')->default(false);
            $table->boolean('is_trending')->default(false);
            $table->boolean('is_best_selling')->default(false);
            $table->boolean('is_on_discount')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('status')->default(true);
            $table->dateTime('last_update_at')->nullable();
            $table->foreign("category_id")->references("id")->on('categories')->onDelete('cascade');
            $table->foreign("sub_category_id")->references("id")->on('sub_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
