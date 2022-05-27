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
            $table->integer('biaya');
            $table->integer('jarak');
            $table->integer('luas_kamar');
            $table->foreignId('kriteria_fasilitas')->constrained('criteria_facilities');
            $table->string('thumbnail');
            $table->enum('status',['diarsipkan','ditampilkan'])->default('ditampilkan');
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
