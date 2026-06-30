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
        Schema::create('kelas_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mata_kuliah');
            $table->foreignId('dosen_id')->constrained('users')->onDelete('cascade');
            $table->string('ruangan');
            $table->boolean('status_absen')->default(0);
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
        Schema::dropIfExists('kelas_kuliahs');
    }
};
