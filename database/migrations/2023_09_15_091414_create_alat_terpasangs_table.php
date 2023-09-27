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
        Schema::create('alat_terpasangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rs_id');
            $table->foreign('rs_id')->references('id')->on('rumah_sakits')->onDelete('cascade');
            $table->unsignedBigInteger('alat_id');
            $table->foreign('alat_id')->references('id')->on('alats')->onDelete('cascade');
            $table->string('nomor_seri', 100);
            $table->date('tanggal_pemasangan');
            $table->string('status_pemasangan', 15);
            $table->date('tanggal_pengiriman');
            $table->date('tanggal_diterima');
            $table->unsignedBigInteger('garansi_id');
            $table->foreign('garansi_id')->references('id')->on('garansis')->onDelete('cascade');
            $table->date('tanggal_mulai_garansi');
            $table->date('tanggal_selesai_garansi');
            $table->string('nama_teknisi_lab', 100);
            $table->enum('is_delete', ['1', '0'])->default('0');
            $table->date('tgl_penghapusan')->default('0000-00-00');
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
        Schema::dropIfExists('alat_terpasangs');
    }
};
