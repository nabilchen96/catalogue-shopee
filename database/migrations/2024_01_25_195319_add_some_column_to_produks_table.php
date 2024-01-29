<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnToProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->string('kategori')->nullable();
            $table->string('rating')->nullable();
            $table->integer('harga_start')->nullable();
            $table->integer('harga_end')->nullable();
            $table->text('spesifikasi')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('foto_pertama')->nullable();
            $table->string('foto_kedua')->nullable();
            $table->string('foto_ketiga')->nullable();
            $table->string('foto_keempat')->nullable();
            $table->string('foto_kelima')->nullable();
            $table->string('afiliasi_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produks', function (Blueprint $table) {
            //
        });
    }
}
