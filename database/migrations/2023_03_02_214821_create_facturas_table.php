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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique();
            $table->date('fecha')->nullable();
            $table->text('nombre_cliente')->nullable();
            $table->BigInteger('vendedor_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();
            
           $table->foreign('vendedor_id')->references('id')->on('vendedors')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
