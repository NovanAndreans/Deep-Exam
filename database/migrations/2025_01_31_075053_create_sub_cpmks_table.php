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
        Schema::create('sub_cpmks', function (Blueprint $table) use ($rps) {
            $table->id();
            $table->string('subcpmk');
            $table->foreignId('cpmk_id');
            $table->timestamps();

            $table->foreign('cpmk_id')->references($rps->getKeyName())->on($rps->getTable())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_cpmks');
    }
};
