<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_categories', function (Blueprint $table) {
            $table->id();
            $table->string('meal_slug');
            $table->string('category_slug');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('meal_slug')->references('slug')->on('meals')->onDelete('cascade');
            $table->foreign('category_slug')->references('slug')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meal_categories');
    }
};
