<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixQuestionWeightColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `questions` CHANGE COLUMN `weight` `weight` DECIMAL(25, 7) NOT NULL DEFAULT 0;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `questions` CHANGE COLUMN `weight` `weight` INT(10) NOT NULL DEFAULT 0;");
    }
}
