<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            $table->foreignId('date_id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('minutes')->nullable();
            $table->string('seconds')->nullable();
            $table->tinyInteger('completed')->default(0);
            $table->timestamps();

            $table->foreign('date_id')->references('id')->on('date_task');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task');
    }
}
