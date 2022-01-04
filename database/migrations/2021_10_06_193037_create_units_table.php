<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('short_name');
            $table->string('long_name');
            $table->string('phone_main');
            $table->string('phone_reserve');
            $table->string('email');
            $table->string('unit_manager');
            $table->string('unit_manager_phone');
            $table->string('unit_manager_email');
            $table->string('unit_safety_manager');
            $table->string('unit_safety_manager_phone');
            $table->string('unit_safety_manager_email');
            $table->string('legal_address');
            $table->string('post_address');
            $table->string('parent_unit_id');
            $table->string('status');
            $table->binary('logo_unit');
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
        Schema::dropIfExists('units');
    }
}
