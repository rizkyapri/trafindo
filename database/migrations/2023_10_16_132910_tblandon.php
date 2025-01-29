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
        Schema::create('tblAndon', function (Blueprint $table) {
            $table->id();
            $table->string('Andon_No')->nullable();
            $table->string('Andon_Serie')->nullable() ;
            $table->string('Guard_ID')->nullable();
            $table->string('Guard_Name')->nullable();
            $table->string('Guard_HPWA')->nullable();
            $table->string('Workcenter')->nullable();
            $table->string('RiseUp_EmployeeNo')->nullable();
            $table->string('RiseUp_EmployeeName')->nullable();
            $table->string('RiseUp_OprNo')->nullable() ;
            $table->string('DescriptionProblem')->nullable();
            $table->dateTime('AndonDateOpen')->nullable();
            $table->dateTime('AndonDateReceived')->nullable();
            $table->string('Received_EmployeeID')->nullable();
            $table->text('DescriptionSolving')->nullable();
            $table->dateTime('AndonDateSolving')->nullable();
            $table->string('Solved_EmployeeID')->nullable();
            $table->dateTime('AndonDateAccepted')->nullable();
            $table->integer('Solving_Score')->nullable();
            $table->text('AndonRemark')->nullable();
            $table->dateTime('AndonDateClosed')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblAndon');
    }
};
