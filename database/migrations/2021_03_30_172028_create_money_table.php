<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoneyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('structure_id')->nullable();
            $table->string('object');
            $table->string('date');
            $table->string('month');
            $table->string('year');
            $table->string('priod');
            $table->text('desc')->nullable();
            $table->integer('amount')->nullable();
            $table->string('unit')->nullable();
            $table->bigInteger('cost')->nullable();
            $table->bigInteger('debet')->nullable();
            $table->bigInteger('kredit')->nullable();
            $table->bigInteger('saldo');
            $table->timestamps();
            $table->foreign('structure_id')->references('id')->on('structures')->onDelete("cascade")->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('money');
    }
}
