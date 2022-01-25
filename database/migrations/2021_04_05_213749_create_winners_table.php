<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWinnersTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('winners', function (Blueprint $table) {
         $table->id();
         $table->unsignedBigInteger('hima_id');
         $table->unsignedBigInteger('contest_id');
         $table->integer('rank');
         $table->foreign('hima_id')->references('id')->on('himas')->onDelete('cascade')->onUpdate('cascade');
         $table->foreign('contest_id')->references('id')->on('contests')->onDelete('cascade')->onUpdate('cascade');

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
      Schema::dropIfExists('winners');
   }
}
