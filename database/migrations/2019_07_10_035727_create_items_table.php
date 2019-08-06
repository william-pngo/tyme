<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description');
            $table->string('img_path');
            $table->unsignedBigInteger('genre_id');
            $table->unsignedBigInteger('country_id');
            $table->timestamps();

            $table->foreign('genre_id')
            ->references('id')
            ->on('genres')
            ->onDelete('restrict')
            ->onUpdate('cascade');

            $table->foreign('country_id')
            ->references('id')
            ->on('countries')
            ->onDelete('restrict')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
