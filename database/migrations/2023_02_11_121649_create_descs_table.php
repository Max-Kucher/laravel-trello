<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descs', function (Blueprint $table) {
            $table->id();
            $table->string('desc_name');
            $table->text('desc_description');
            $table->timestamps();
        });

        Schema::create('desc_lists', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->text('item_description');

            $table->bigInteger('desc_id')->unsigned();

            $table->timestamps();

            $table->foreign('desc_id')
                ->references('id')
                ->on('descs')
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
        Schema::dropIfExists('descs');
        Schema::dropIfExists('desc_lists');
    }
}
