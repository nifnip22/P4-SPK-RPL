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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_harga', 10, 2);
            $table->string('jenis_pembayaran');
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->timestamps();

            $table->foreign('pelanggan_id')->on('pelanggans')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
