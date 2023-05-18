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
        Schema::create('vendedors', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('cedula', 20)->unique();
            $table->string('nombre', 100);
            $table->string('telefono', 20);
            $table->string('correo', 100);
            
            $table->timestamps();
            $table->softDeletes();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendedors');
    }
};
