<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePanelistsVoteDecisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vote_decision', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('appeal_id');
            $table->string('panelist_name');
            $table->text('comment');
            $table->enum('vote_type', ['decision', 'ruling']);
            $table->enum('vote', ['TR', 'ADJ', 'AAS', 'AWM', 'PP']);
            $table->timestamps();
        });
    }
/*TR	Table Result
ADJ	Assigned Adjusted score
AAS	Artificial Adjusted Score
AWM	Appeal without merit
PP	Procedural Penalty*/
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vote_decision');
    }
}
