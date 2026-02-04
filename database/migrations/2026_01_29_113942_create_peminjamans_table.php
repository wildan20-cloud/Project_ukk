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
   Schema::create('peminjamans', function (Blueprint $table) {
    $table->id();
    // Relasi ke Users dan Barangs
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('barang_id')->constrained()->onDelete('cascade');
    
    $table->integer('jumlah');
    $table->enum('status', ['pending', 'approved', 'rejected', 'returned'])->default('pending');
    $table->date('tgl_pinjam')->nullable();
    $table->date('tgl_kembali')->nullable();
    $table->timestamps();
});
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
