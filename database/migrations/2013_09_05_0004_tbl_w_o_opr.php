<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tblWOOpr', function (Blueprint $table) {
            $table->id();
            $table->integer('OprNumber')->nullable();
            $table->string('OprName')->nullable();
            $table->text('OprDescription')->nullable();
            $table->string('Workcenter')->nullable();
            $table->bigInteger('Stdhrs')->nullable();
            $table->integer('WOID')->nullable();
            $table->bigInteger('EmployeeID')->nullable();
            $table->dateTime('OprPlanBegin')->nullable();
            $table->dateTime('OprPlanEnd')->nullable();
            $table->dateTime('OprBeginDate')->nullable();
            $table->dateTime('OprEndDate')->nullable();
            $table->string('OprStatus')->nullable();
            $table->bigInteger('StdSetupTime');
            $table->integer('StdRunTime')->nullable();
            $table->text('Oprnote1')->nullable();
            $table->text('Oprnote2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblWOOpr');
    }
};
