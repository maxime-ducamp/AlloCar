<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJourneysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journeys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('departure');
            $table->string('arrival');
            $table->unsignedTinyInteger('seats');
            $table->dateTime('departure_datetime');
            $table->dateTime('arrival_datetime');
            $table->string('estimated_distance');
            $table->boolean('allows_pets')->default(false);
            $table->boolean('allows_smoking')->default(false);
            $table->text('driver_comment')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journeys');
    }
}
