<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
             ->references('id')->on('users')
             ->onDelete('cascade');
            $table->bigInteger('course_id')->unsigned();
            $table->foreign('course_id')
              ->references('id')->on('courses')
              ->onDelete('cascade');
            $table->date('date_played');
            $table->integer('score');
            $table->string('tee',16);
            $table->integer('holes');
            $table->float('diff', 5, 2);
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
        Schema::dropIfExists('scores');
    }
}
