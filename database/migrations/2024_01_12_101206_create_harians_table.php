<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHariansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harians', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_harian');
            $table->string('nama_pengurus');
            $table->text('masalah');
            $table->text('tindakan')->nullable();
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('harians');
    }
}
