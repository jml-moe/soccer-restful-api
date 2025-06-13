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
        //
        Schema::create('pertandingan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('lokasi');
            $table->unsignedBigInteger('tim_home_id');
            $table->unsignedBigInteger('tim_away_id');
            $table->integer('skor_home')->nullable();
            $table->integer('skor_away')->nullable();
            $table->unsignedBigInteger('liga_id');
            $table->timestamps();

            // $table->foreign('tim_home_id')->references('id')->on('tim')->onDelete('cascade');
            // $table->foreign('tim_away_id')->references('id')->on('tim')->onDelete('cascade');
            // $table->foreign('liga_id')->references('id')->on('liga')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('pertandingan');
    }
};
