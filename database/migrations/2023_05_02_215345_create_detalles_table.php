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
        Schema::create('detalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('factura_id');
            $table->unsignedBigInteger('producto_id' );
            $table->integer('cantidad');
            $table->decimal('subtotal', 8, 2);
            
            
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('factura_id')->references('id')->on('facturas')->onUpdate('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onUpdate('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles');
    }
};
