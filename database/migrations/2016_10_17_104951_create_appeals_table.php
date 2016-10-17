<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appeals', function (Blueprint $table) {
            $table->increments('id');
            // event
            $table->unsignedInteger('event_id');
            // hand/board
            $table->unsignedInteger('board_id');
            // players
            $table->string('player_north');
            $table->string('player_south');
            $table->string('player_east');
            $table->string('player_west');
            // director
            $table->string('director_name');
            // comitee

            // director ruling
            $table->text('director_ruling');
            $table->text('appeal_reason');
            $table->text('decision');

            $table->dateTime('appeal_time');
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
        Schema::dropIfExists('appeals');
    }
}
