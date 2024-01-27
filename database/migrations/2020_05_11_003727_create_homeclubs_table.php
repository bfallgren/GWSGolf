<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homeclubs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
             ->references('id')->on('users')
             ->onDelete('cascade');
            $table->bigInteger('course_id')->unsigned();
            $table->foreign('course_id')
             ->references('id')->on('courses')
             ->onDelete('cascade');
            $table->unsignedDecimal('avg_daily_fee', 8, 2);
            $table->unsignedDecimal('annual_membership_fee', 8, 2);
            $table->unsignedDecimal('shop_credit', 8, 2);
            $table->string('image',255);
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
        Schema::dropIfExists('homeclubs');
    }
}
