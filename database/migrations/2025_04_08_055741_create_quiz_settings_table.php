<?php

use App\Models\Rps;
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
        $rps = new Rps();
        Schema::create('quiz_settings', function (Blueprint $table) use ($rps) {
            $table->id();
            $table->integer('jumlah_soal')->default(10);
            $table->integer('batas_waktu')->default(30);
            $table->integer('attempt_quiz')->default(1);
            $table->integer('soal_per_sesi')->default(3);
            $table->foreignId('rps_id');
            
            $table->timestamps();

            $table->foreign('rps_id')->references($rps->getKeyName())->on($rps->getTable())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_settings');
    }
};
