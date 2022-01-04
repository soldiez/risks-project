<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

class CreateUnitTerritoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_territories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->nullable(); //TODO unit link, remove nullable
            $table->text('name');
            $table->foreignId('responsible_id')->nullable(); //TODO resp person
            $table->foreignId('unit_department_id')->nullable(); //TODO unit dep link;
            $table->text('coordinate')->nullable();
            $table->text('address')->nullable();
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
        Schema::dropIfExists('unit_territories');
    }
}
