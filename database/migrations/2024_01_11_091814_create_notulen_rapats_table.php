<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotulenRapatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notulen_rapats', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_rapat')->nullable();
            $table->date('tanggal_rapat')->nullable();
            $table->string('tempat')->nullable();
            $table->string('acara')->nullable();
            $table->integer('total_hadir')->nullable();
            $table->string('pimpinan')->nullable();
            $table->text('hasil')->nullable();
            $table->string('id_user')->nullable();
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
        Schema::dropIfExists('notulen_rapats');
    }
}
