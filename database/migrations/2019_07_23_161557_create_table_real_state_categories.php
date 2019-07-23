<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRealStateCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_state_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('real_state_id');
            $table->unsignedBigInteger('categorie_id');

            $table->foreign('real_state_id')->references('id')->on('real_state');
            $table->foreign('categorie_id')->references('id')->on('real_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('real_state_categories');
    }
}
