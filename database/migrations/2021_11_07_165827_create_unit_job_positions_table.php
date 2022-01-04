<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

class CreateUnitJobPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_job_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_department_id')->nullable();
            $table->text('name');
            $table->text('garde')->nullable();
            $table->text('info')->nullable();
            $table->string('status')->nullable();
            NestedSet::columns($table);
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
        Schema::dropIfExists('unit_job_positions');
    }
}
