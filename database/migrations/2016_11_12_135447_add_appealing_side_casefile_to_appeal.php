<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAppealingSideCasefileToAppeal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appeals', function($table){
            $table->string('casebook')->after('user_id');
            $table->enum('side_appealing', ['ns', 'ew'])->after('committee')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appeals', function ($table){
            $table->dropColumn(['casebook', 'side_appealing']);
        });
    }
}
