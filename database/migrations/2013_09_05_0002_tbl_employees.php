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
        Schema::create('tblEmployees', function (Blueprint $table) {
            $table->id();
            $table->string('Name')->default('0');
            $table->string('EmployeeNumber')->default('0');
            $table->bigInteger('department_id');
            $table->string('Title')->default('0');
            $table->string('Photograph')->default('0')->nullable();
            $table->text('Notes')->nullable();
            $table->integer('InProgress')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblEmployees');
    }
};
