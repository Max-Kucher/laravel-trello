<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatedesksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desks', function (Blueprint $table) {
            $table->id();
            $table->string('desk_name');
            $table->text('desk_description');
            $table->timestamps();
        });

        Schema::create('desk_lists', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->text('item_description');

            $table->bigInteger('desk_id')->unsigned();

            $table->timestamps();

            $table->foreign('desk_id')
                ->references('id')
                ->on('desks')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('desks');
        Schema::dropIfExists('desk_lists');
    }
}
