<?php

use App\Models\Meeting;
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
        $meeting = new Meeting();
        Schema::create('kisi_kisis', function (Blueprint $table) use ($meeting) {
            $table->id();
            $table->string('taksonomi_bloom');
            $table->string('type');
            $table->string('kisi_kisi');
            $table->foreignId('meeting_id');
            $table->timestamps();

            $table->foreign('meeting_id')->references($meeting->getKeyName())->on($meeting->getTable())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kisi_kisis');
    }
};
