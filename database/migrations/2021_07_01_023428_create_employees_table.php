<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('office_id')
                ->nullable()
                ->constrained('offices')
                ->references('id')
                ->onDelete('SET NULL');
            $table->foreignId('report_to_id')
                ->nullable()
                ->constrained('employees')
                ->references('id')
                ->onDelete('SET NULL');

            $table->string('uuid');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('extension');
            $table->string('email');
            $table->string('job_title');
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
        Schema::dropIfExists('employees');
    }
}
