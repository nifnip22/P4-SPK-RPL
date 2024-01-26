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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->unsignedBigInteger('kategori_produk_id');
            $table->decimal('harga_produk', 10, 2);
            $table->integer('stok_produk');
            $table->string('gambar');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('kategori_produk_id')->references('id')->on('kategori_produks');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
