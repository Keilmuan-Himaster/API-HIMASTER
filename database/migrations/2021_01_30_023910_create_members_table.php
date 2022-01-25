<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('structure_id');
            $table->text('address')->nullable();
            $table->string('nim');
            $table->string('majors');
            $table->integer('year');
            $table->integer('priod');
            $table->enum('grade',['koordinator','staf']);
            $table->timestamps();
            $table->foreign('structure_id')->references('id')->on('structures')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
