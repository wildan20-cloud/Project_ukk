<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // Di dalam file migration create_barangs_table
public function up(): void
{
   Schema::create('barangs', function (Blueprint $table) {
    $table->id();
    // Relasi ke Kategoris
    $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
    $table->string('nama_barang');
    $table->integer('stok');
    $table->timestamps();
});
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
