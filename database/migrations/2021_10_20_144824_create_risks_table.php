<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRisksTable extends Migration //TODO make risk migration table
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id');//nested
            $table->foreignId('territory_id')->nullable(); //nested
            $table->foreignId('department_id')->nullable(); //nested
            $table->foreignId('job_position_id')->nullable();
            $table->string('process')->nullable();
            $table->string('product')->nullable();
            $table->string('service')->nullable();
            $table->text('hazard_info');
            $table->foreignId('hazard_category_id')->nullable();
            $table->foreignId('injured_body_part_id')->nullable();
            $table->text('base_risk_info');
            $table->text('base_preventive_actions');
            $table->string('base_severity');
            $table->string('base_probability');
            $table->string('base_frequency');
            $table->string('base_calc_risk');
            $table->text('prop_preventive_actions');
            $table->string('prop_severity');
            $table->string('prop_probability');
            $table->string('prop_frequency');
            $table->string('prop_calc_risk');
            $table->foreignId('author_id');
            $table->timestamp('create_date_time');
            $table->text('create_persons')->nullable();
            $table->timestamp('next_review_date')->nullable();
            $table->foreignId('control_person_id');
            $table->timestamp('control_review_date')->nullable();
            $table->foreignId('risk_status_id');
            $table->foreignId('action_id'); //link to actions
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
        Schema::dropIfExists('risks');
    }
}
