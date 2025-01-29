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
        Schema::create('tblEmployeesTasks', function (Blueprint $table) {
            $table->id();
            $table->foreignID('EmployeeID')->nullable();
            $table->foreignID('OprID')->nullable();
            $table->dateTime('TaskDateStart')->nullable();
            $table->dateTime('TaskDateEnd')->nullable();
            $table->string('TaskStatus')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblEmployeesTasks');
    }
};
