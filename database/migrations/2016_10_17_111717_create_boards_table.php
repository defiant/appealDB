<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('appeal_id');
            $table->string('hand', 67);
            $table->unsignedTinyInteger('board_no');
            $table->unsignedTinyInteger('dealer');
            $table->enum('vul', ['none', 'ew', 'ns', 'all']);
            $table->boolean('screen')->default(false);
            $table->text('bidding');
            $table->text('alerts');
            $table->string('lead', 2);
            $table->string('table_result', 6);
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
        Schema::dropIfExists('boards');
    }
}
