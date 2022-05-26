<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kosts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kategori')->constrained('kost_categories');
            $table->string('nama_kost');
            $table->string('alamat_kost');
            $table->foreignId('kriteria_biaya')->constrained('criteria_prices');
            $table->foreignId('kriteria_jarak')->constrained('criteria_distances');
            $table->foreignId('kriteria_luas_kamar')->constrained('criteria_room_sizes');
            $table->foreignId('kriteria_fasilitas')->constrained('criteria_facilities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kosts');
    }
};
