<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumption', function (Blueprint $table) {
            $table->integer('abonne_id');
            $table->string('type_consumption', 500);
            $table->date('date_consumption');
            $table->time('time_consumption');
            $table->string('duration_real_consumption', 50)->nullable();
            $table->string('duration_invoiced_consumption', 50)->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consumption');
    }
}
