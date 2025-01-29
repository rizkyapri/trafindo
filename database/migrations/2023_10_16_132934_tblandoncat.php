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
        Schema::create('tblAndonCat', function (Blueprint $table) {
            $table->id();
            $table->string('CodeAndon')->nullable();
            $table->string('CategoryProblem')->nullable() ;
            $table->string('AssignTo')->nullable();
            $table->string('Guard_EmployeeID')->nullable();
            $table->string('ContactPerson')->nullable();
            $table->string('HP_WA')->nullable();
            $table->integer('Sirene')->nullable();
            $table->string('AndonSerie')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblAndonCat');
    }
};
