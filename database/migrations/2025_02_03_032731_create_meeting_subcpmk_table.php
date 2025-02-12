<?php

use App\Models\Meeting;
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
        $meeting = new Meeting();
        $subCpmk = new SubCpmk();
        Schema::create('meeting_subcpmks', function (Blueprint $table) use ($meeting, $subCpmk) {
            $table->id();
            $table->foreignId('meeting_id');
            $table->foreignId('subcpmk_id');
            $table->timestamps();

            $table->foreign('meeting_id')->references($meeting->getKeyName())->on($meeting->getTable())->onDelete('cascade');
            $table->foreign('subcpmk_id')->references($subCpmk->getKeyName())->on($subCpmk->getTable())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_subcpmk');
    }
};
