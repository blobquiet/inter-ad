<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('evento', function (Blueprint $table) {
             $table->increments('id');
             $table->string('name', 60);
             $table->string('infoEv', 60);
             //$table->string('picture', 60);
             $table->date('fechaEv');
             $table->date('fechaFEv');
             $table->timestamps();
             $table->softDeletes();
         });
     }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evento');
    }
}
