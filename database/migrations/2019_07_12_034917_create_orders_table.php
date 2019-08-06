<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();

            $table->foreign('item_id')
            ->references('id')
            ->on('items')
            ->onDelete('restrict')
            ->onUpdate('cascade');

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('restrict')
            ->onUpdate('cascade');

            $table->foreign('status_id')
            ->references('id')
            ->on('statuses')
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
        Schema::dropIfExists('orders');
    }
}
