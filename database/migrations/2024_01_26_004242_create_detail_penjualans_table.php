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
        Schema::create('detail_penjualans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penjualan_id');
            $table->unsignedBigInteger('produk_id');
            $table->integer('jumlah_produk');
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();

            $table->foreign('penjualan_id')->on('penjualans')->references('id')->onDelete('cascade');
            $table->foreign('produk_id')->on('produks')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualans');
    }
};
