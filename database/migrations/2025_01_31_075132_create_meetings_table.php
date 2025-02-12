<?php

use App\Models\Rps;
use App\Models\SubCpmk;
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
        Schema::create('meetings', function (Blueprint $table) use ($rps) {
            $table->id();
            $table->string('title');
            $table->text('desc');
            $table->integer('minggu_ke');
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
        Schema::dropIfExists('meetings');
    }
};
