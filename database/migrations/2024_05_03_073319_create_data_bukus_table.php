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
        Schema::create('data_bukus', function (Blueprint $table) {
            $table->id();
            $table->string('isbn', 50);
            $table->string('judul', 100);
            $table->string('penulis');
            $table->integer('tahun');
            $table->integer('jumlah_buku');
            $table->string('kategori', 50);
            $table->foreignId('id_pustakawan')->nullable()->constrained('pustakawans')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_bukus');
    }
};
