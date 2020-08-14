<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsvcomputesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csv_computes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('calculation');
            $table->unsignedBigInteger('compute_column_id');
            $table->unsignedBigInteger('group_by_column_id');
            $table->unsignedBigInteger('csvfile_id');
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
        Schema::dropIfExists('csvcomputes');
    }
}
