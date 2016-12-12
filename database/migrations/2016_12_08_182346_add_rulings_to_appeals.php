<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRulingsToAppeals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appeals', function($table){
            $table->boolean('table_result_stands')->after('ruling')->default(false);
            $table->string('td_ruling')->after('ruling')->nullable();
            $table->string('ac_ruling')->after('ruling_upheld')->nullable();
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
            $table->dropColumn(['table_result_stands', 'td_ruling', 'ac_ruling']);
        });
    }
}
