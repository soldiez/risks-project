<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

class CreateUnitDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->nullable();
            $table->text('name');
            $table->foreignId('manager_job_position_id')->nullable();
            $table->foreignId('unit_territory_id')->nullable();
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
        Schema::dropIfExists('unit_departments');
    }
}
