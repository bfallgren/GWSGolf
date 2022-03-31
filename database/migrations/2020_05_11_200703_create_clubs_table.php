<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clubs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
             ->references('id')->on('users')
             ->onDelete('cascade');
            $table->string('name',24);
            $table->string('vendor',24)->nullable();
            $table->decimal('loft',5,3)->nullable();
            $table->decimal('lie',5,3)->nullable();
            $table->decimal('length',5,3)->nullable();
            $table->string('swing_weight',2)->nullable();
            $table->decimal('yardage',4,0)->nullable();
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
        Schema::dropIfExists('clubs');
    }
}
