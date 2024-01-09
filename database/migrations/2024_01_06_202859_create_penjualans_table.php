<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_konsumen')->nullable();
            $table->string('id_barang');
            $table->integer('harga_modal')->nullable;
            $table->string('jumlah_penjualan');
            $table->integer('harga_jual');
            $table->integer('uang_konsumen');
            $table->date('tanggal_penjualan');
            $table->text('keterangan');
            $table->string('id_user');
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
        Schema::dropIfExists('penjualans');
    }
}
