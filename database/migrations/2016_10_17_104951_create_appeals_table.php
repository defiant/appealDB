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
            $table->unsignedTinyInteger('category_id');
            // players
            $table->string('player_north');
            $table->string('player_south');
            $table->string('player_east');
            $table->string('player_west');
            $table->string('director');
            $table->string('committee');

            $table->text('facts');
            $table->text('ruling');
            $table->text('appeal_reason');
            $table->text('decision');
            $table->string('laws');

            $table->dateTime('appeal_time');
            $table->boolean('status')->default(false);

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
