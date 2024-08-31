<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemHasIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_item_has_ingredients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_has_item_id');
            $table->foreign('order_has_item_id')->references('id')->on('order_has_items')->onDelete('cascade');
            $table->unsignedBigInteger('food_ingredient_item_id');
            $table->foreign('food_ingredient_item_id')->references('id')->on('food_ingredient_items')->onDelete('cascade');
            $table->float('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_item_has_ingredients');
    }
}
